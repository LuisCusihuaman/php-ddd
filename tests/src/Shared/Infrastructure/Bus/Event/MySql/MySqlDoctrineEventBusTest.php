<?php

namespace LuisCusihuaman\Tests\Shared\Infrastructure\Bus\Event\MySql;

use Doctrine\ORM\EntityManager;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\DomainEventMapping;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\MySql\MySqlDoctrineDomainEventsConsumer;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\MySql\MySqlDoctrineEventBus;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseCreatedDomainEventMother;
use LuisCusihuaman\Tests\Mooc\CoursesCounter\Domain\CoursesCounterIncrementedDomainEventMother;
use LuisCusihuaman\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;

final class MySqlDoctrineEventBusTest extends InfrastructureTestCase
{
    private $bus;
    private $consumer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bus = new MySqlDoctrineEventBus($this->service(EntityManager::class));
        $this->consumer = new MySqlDoctrineDomainEventsConsumer(
            $this->service(EntityManager::class),
            $this->service(DomainEventMapping::class)
        );
    }

    private function spySubscriberCallable(DomainEvent ...$expectedDomainEvents): callable
    {
        return function (DomainEvent $domainEvent) use ($expectedDomainEvents): void {
            $this->assertContainsEquals($domainEvent, $expectedDomainEvents);
        };
    }

    /** @test */
    public function it_should_publish_and_consume_domain_events_from_msql(): void
    {
        $domainEvent = CourseCreatedDomainEventMother::random();
        $anotherDomainEvent = CoursesCounterIncrementedDomainEventMother::random();

        $this->bus->publish($domainEvent, $anotherDomainEvent);
        $this->consumer->consume($this->spySubscriberCallable($domainEvent, $anotherDomainEvent), 2);
    }
}