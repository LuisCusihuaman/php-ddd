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

final class RabbitMqEventBusTest extends InfrastructureTestCase
{
    private $exchangeName;
    private $configurer;
    private $eventBus;
    private $consumer;
    private $fakeSubscriber;

    protected function setUp(): void
    {
        parent::setUp();

        $connection = $this->service(RabbitMqConnection::class);

        $this->exchangeName = 'test_domain_events';
        $this->configurer = new RabbitMqConfigurer($connection);
        $this->eventBus = new RabbitMqEventBus($connection, $this->exchangeName);
        $this->consumer = new RabbitMqDomainEventsConsumer(
            $connection,
            $this->service(DomainEventJsonDeserializer::class)
        );
        $this->fakeSubscriber = new TestAllWorksOnRabbitMqEventsPublished();
        $queueName = RabbitMqQueueNameFormatter::format($this->fakeSubscriber);

        $connection->queue($queueName)->delete();
    }

    private function consumer(DomainEvent ...$expectedDomainEvents): callable
    {
        return function (DomainEvent $domainEvent) use ($expectedDomainEvents): void {
            $this->assertContainsEquals($domainEvent, $expectedDomainEvents);
        };
    }

    /** @test */
    public function it_should_publish_and_consume_domain_events_from_rabbitmq(): void
    {
        $this->configurer->configure($this->exchangeName, $this->fakeSubscriber);
        $domainEvent = CourseCreatedDomainEventMother::random();

        $this->eventBus->publish($domainEvent);
        $this->consumer->consume(
            $this->consumer($domainEvent),
            RabbitMqQueueNameFormatter::format($this->fakeSubscriber)
        );
    }

    /** @test */
    public function it_should_throw_an_exception_consuming_non_existing_domain_events(): void
    {
        $this->expectException(RuntimeException::class);
        $this->configurer->configure($this->exchangeName, $this->fakeSubscriber);
        $domainEvent = CoursesCounterIncrementedDomainEventMother::random();

        $this->eventBus->publish($domainEvent);
        $this->consumer->consume(
            $this->consumer($domainEvent),
            RabbitMqQueueNameFormatter::format($this->fakeSubscriber)
        );
    }
}
