<?php


namespace LuisCusihuaman\Tests\Mooc\Courses\Application\Create;


use LuisCusihuaman\Mooc\Courses\Application\Create\CreateCourseCommand;
use LuisCusihuaman\Mooc\Courses\Domain\CourseDuration;
use LuisCusihuaman\Mooc\Courses\Domain\CourseName;
use LuisCusihuaman\Mooc\Shared\Domain\Course\CourseId;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseDurationMother;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseIdMother;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseNameMother;

final class CreateCourseCommandMother
{
    public static function create(CourseId $id, CourseName $name, CourseDuration $duration): CreateCourseCommand
    {
        return new CreateCourseCommand($id->value(), $name->value(), $duration->value());
    }

    public static function random(): CreateCourseCommand
    {
        return self::create(
            CourseIdMother::random(),
            CourseNameMother::random(),
            CourseDurationMother::random());
    }
}
