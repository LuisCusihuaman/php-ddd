<?php

namespace LuisCusihuaman\Tests\Shared\Infrastructure\Bus\Event;

use Doctrine\ORM\EntityManager;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\DoctrineDomainEventPublisher;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\DoctrineDomainEventsConsumer;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\DomainEventMapping;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseCreatedDomainEventMother;
use LuisCusihuaman\Tests\Mooc\CoursesCounter\Domain\CoursesCounterIncrementedDomainEventMother;
use LuisCusihuaman\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;

final class DoctrineDomainEventsConsumerTest extends InfrastructureTestCase
{
    private $publisher;
    private $consumer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->publisher = new DoctrineDomainEventPublisher($this->service(EntityManager::class));
        $this->consumer = new DoctrineDomainEventsConsumer(
            $this->service(EntityManager::class),
            $this->service(DomainEventMapping::class)
        );
    }

    private function consumer(DomainEvent ...$expectedDomainEvents): callable
    {
        return function (DomainEvent $domainEvent) use ($expectedDomainEvents): void {
            $this->assertContainsEquals($domainEvent, $expectedDomainEvents);
        };
    }

    /** @test */
    public function it_should_publish_domain_events(): void
    {
        $domainEvent = CourseCreatedDomainEventMother::random();
        $anotherDomainEvent = CoursesCounterIncrementedDomainEventMother::random();

        $this->publisher->publish($domainEvent, $anotherDomainEvent);

        $this->consumer->consume($this->consumer($domainEvent, $anotherDomainEvent), 2);
    }
}