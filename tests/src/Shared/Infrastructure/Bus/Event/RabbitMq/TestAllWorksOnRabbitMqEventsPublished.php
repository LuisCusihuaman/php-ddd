<?php

namespace LuisCusihuaman\Tests\Shared\Infrastructure\Bus\Event\RabbitMq;

use LuisCusihuaman\Mooc\Courses\Domain\CourseCreatedDomainEvent;
use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounterIncrementedDomainEvent;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEventSubscriber;

final class TestAllWorksOnRabbitMqEventsPublished implements DomainEventSubscriber
{
    public static function subscribedTo(): array
    {
        return [
            CourseCreatedDomainEvent::class,
            CoursesCounterIncrementedDomainEvent::class,
        ];
    }

    /** @param CourseCreatedDomainEvent|CoursesCounterIncrementedDomainEvent $event */
    public function __invoke($event)
    {
    }
}