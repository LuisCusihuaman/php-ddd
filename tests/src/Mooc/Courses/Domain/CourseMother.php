<?php


namespace LuisCusihuaman\Tests\Mooc\Courses\Domain;

use LuisCusihuaman\Mooc\Courses\Application\Create\CreateCourseCommand;
use LuisCusihuaman\Mooc\Courses\Domain\Course;
use LuisCusihuaman\Mooc\Courses\Domain\CourseDuration;
use LuisCusihuaman\Mooc\Courses\Domain\CourseName;
use LuisCusihuaman\Mooc\Shared\Domain\Course\CourseId;

final class CourseMother
{
    public static function create(CourseId $id, CourseName $name, CourseDuration $duration): Course
    {
        return new Course($id, $name, $duration);
    }

    public static function fromRequest(CreateCourseCommand $command): Course
    {
        return self::create(
            CourseIdMother::create($command->id()),
            CourseNameMother::create($command->name()),
            CourseDurationMother::create($command->duration())
        );
    }

    public static function random(): Course
    {
        return self::create(
            CourseIdMother::random(),
            CourseNameMother::random(),
            CourseDurationMother::random());
    }
}



