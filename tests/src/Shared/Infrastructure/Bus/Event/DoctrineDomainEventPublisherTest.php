<?php

namespace LuisCusihuaman\Tests\Shared\Infrastructure\Bus\Event;

use Doctrine\ORM\EntityManager;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\DoctrineDomainEventPublisher;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseCreatedDomainEventMother;
use LuisCusihuaman\Tests\Mooc\CoursesCounter\Domain\CoursesCounterIncrementedDomainEventMother;
use LuisCusihuaman\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;

final class DoctrineDomainEventPublisherTest extends InfrastructureTestCase
{
    private $publisher;

    protected function setUp(): void
    {
        parent::setUp();
        $this->publisher = new DoctrineDomainEventPublisher($this->service(EntityManager::class));
    }

    /** @test */
    public function it_should_publish_domain_events(): void
    {
        $this->publisher->publish(CourseCreatedDomainEventMother::random());
        $this->publisher->publish(CoursesCounterIncrementedDomainEventMother::random());
    }
}