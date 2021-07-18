<?php


namespace LuisCusihuaman\Mooc\CoursesCounter\Application\Increment;


use LuisCusihuaman\Mooc\Courses\Domain\CourseCreatedDomainEvent;
use LuisCusihuaman\Mooc\Shared\Domain\Course\CourseId;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEventSubscriber;
use function Lambdish\Phunctional\apply;

class IncrementCoursesCounterOnCourseCreated implements DomainEventSubscriber
{
    private CoursesCounterIncrementer $incrementer;

    public function __construct(CoursesCounterIncrementer $incrementer)
    {
        $this->incrementer = $incrementer;
    }

    public static function subscribedTo(): array
    {
        return [CourseCreatedDomainEvent::class];
    }

    public function __invoke(CourseCreatedDomainEvent $event): void
    {
        $courseId = new CourseId($event->aggregateId());
        apply($this->incrementer, [$courseId]);
    }
}