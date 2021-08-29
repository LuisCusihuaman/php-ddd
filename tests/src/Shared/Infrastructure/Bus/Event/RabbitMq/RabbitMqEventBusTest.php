<?php

namespace LuisCusihuaman\Tests\Shared\Infrastructure\Bus\Event\RabbitMq;

use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\DomainEventJsonDeserializer;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqConfigurer;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqConnection;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqDomainEventsConsumer;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqEventBus;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqQueueNameFormatter;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseCreatedDomainEventMother;
use LuisCusihuaman\Tests\Mooc\CoursesCounter\Domain\CoursesCounterIncrementedDomainEventMother;
use LuisCusihuaman\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;
use RuntimeException;
use Throwable;

final class RabbitMqEventBusTest extends InfrastructureTestCase
{
    private $connection;
    private $exchangeName;
    private $configurer;
    private $eventBus;
    private $consumer;
    private $fakeSubscriber;
    private $consumerHasBeenExecuted;

    private function cleanEnvironment(RabbitMqConnection $connection): void
    {
        $connection->queue(RabbitMqQueueNameFormatter::format($this->fakeSubscriber))->delete();
        $connection->queue(RabbitMqQueueNameFormatter::formatRetry($this->fakeSubscriber))->delete();
        $connection->queue(RabbitMqQueueNameFormatter::formatDeadLetter($this->fakeSubscriber))->delete();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = $this->service(RabbitMqConnection::class);

        $this->exchangeName = 'test_domain_events';
        $this->configurer = new RabbitMqConfigurer($this->connection);
        $this->eventBus = new RabbitMqEventBus($this->connection, $this->exchangeName);
        $this->consumer = new RabbitMqDomainEventsConsumer(
            $this->connection,
            $this->service(DomainEventJsonDeserializer::class),
            $this->exchangeName, 1
        );
        $this->fakeSubscriber = new TestAllWorksOnRabbitMqEventsPublished();
        $this->consumerHasBeenExecuted = false;

        $this->cleanEnvironment($this->connection);
    }

    private function assertConsumer(DomainEvent ...$expectedDomainEvents): callable
    {
        return function (DomainEvent $domainEvent) use ($expectedDomainEvents): void {
            $this->assertContainsEquals($domainEvent, $expectedDomainEvents);
            $this->consumerHasBeenExecuted = true;
        };
    }

    /** @test */
    public function it_should_publish_and_consume_domain_events_from_rabbitmq(): void
    {
        $this->configurer->configure($this->exchangeName, $this->fakeSubscriber);
        $domainEvent = CourseCreatedDomainEventMother::random();

        $this->eventBus->publish($domainEvent);
        $this->consumer->consume(
            $this->assertConsumer($domainEvent),
            RabbitMqQueueNameFormatter::format($this->fakeSubscriber)
        );

        $this->assertTrue($this->consumerHasBeenExecuted);
    }

    /** @test */
    public function it_should_throw_an_exception_consuming_non_existing_domain_events(): void
    {
        $this->expectException(RuntimeException::class);
        $this->configurer->configure($this->exchangeName, $this->fakeSubscriber);
        $domainEvent = CoursesCounterIncrementedDomainEventMother::random();

        $this->eventBus->publish($domainEvent);
        $this->consumer->consume(
            $this->assertConsumer($domainEvent),
            RabbitMqQueueNameFormatter::format($this->fakeSubscriber)
        );

        $this->assertTrue($this->consumerHasBeenExecuted);
    }

    /** @test */
    public function it_should_retry_failed_domain_events(): void
    {
        $this->configurer->configure($this->exchangeName, $this->fakeSubscriber);
        $domainEvent = CourseCreatedDomainEventMother::random();

        $this->eventBus->publish($domainEvent);
        $this->simulateErrorConsuming();
        sleep(1);

        $this->consumer->consume(
            $this->assertConsumer($domainEvent),
            RabbitMqQueueNameFormatter::format($this->fakeSubscriber)
        );
    }

    /** @test */
    public function it_should_send_events_to_dead_letter_after_retry_failed_domain_events(): void
    {
        $this->configurer->configure($this->exchangeName, $this->fakeSubscriber);
        $domainEvent = CourseCreatedDomainEventMother::random();

        $this->eventBus->publish($domainEvent);
        $this->simulateErrorConsuming();
        sleep(1);
        $this->simulateErrorConsuming();

        $this->assertDeadLetterContainsEvent(1);
    }

    private function assertDeadLetterContainsEvent(int $expectedNumberOfEvents)
    {
        $totalEventsInDeadLetter = 0;

        $deadLetterQueue = $this->connection->queue(
            RabbitMqQueueNameFormatter::formatDeadLetter($this->fakeSubscriber));

        while ($deadLetterQueue->get(AMQP_AUTOACK)) {
            $totalEventsInDeadLetter++;
        }

        $this->assertSame($expectedNumberOfEvents, $totalEventsInDeadLetter);
    }

    private function simulateErrorConsuming(): void
    {
        try {
            $this->consumer->consume(
                static function (DomainEvent $domainEvent): void {
                    throw new RuntimeException('To test');
                },
                RabbitMqQueueNameFormatter::format($this->fakeSubscriber)
            );
        } catch (Throwable $error) {
            $this->assertInstanceOf(RuntimeException::class, $error);
        }
    }
}