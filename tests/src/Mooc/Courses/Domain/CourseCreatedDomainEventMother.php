<?php


namespace LuisCusihuaman\Tests\Mooc\Courses\Domain;


use LuisCusihuaman\Mooc\Courses\Domain\Course;
use LuisCusihuaman\Mooc\Courses\Domain\CourseCreatedDomainEvent;
use LuisCusihuaman\Mooc\Courses\Domain\CourseDuration;
use LuisCusihuaman\Mooc\Courses\Domain\CourseName;
use LuisCusihuaman\Mooc\Shared\Domain\Course\CourseId;

final class CourseCreatedDomainEventMother
{
    public static function create(CourseId $id, CourseName $name, CourseDuration $duration): CourseCreatedDomainEvent
    {
        return new CourseCreatedDomainEvent($id->value(), $name->value(), $duration->value());
    }

    public static function fromCourse(Course $course): CourseCreatedDomainEvent
    {
        return self::create($course->id(), $course->name(), $course->duration());
    }

    public static function random(): CourseCreatedDomainEvent
    {
        return self::create(CourseIdMother::random(), CourseNameMother::random(), CourseDurationMother::random());
    }
}
