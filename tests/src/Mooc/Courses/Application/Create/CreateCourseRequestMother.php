<?php


namespace LuisCusihuaman\Tests\Mooc\Courses\Application\Create;


use LuisCusihuaman\Mooc\Courses\Application\Create\CreateCourseRequest;
use LuisCusihuaman\Mooc\Courses\Domain\CourseDuration;
use LuisCusihuaman\Mooc\Courses\Domain\CourseId;
use LuisCusihuaman\Mooc\Courses\Domain\CourseName;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseDurationMother;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseIdMother;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseNameMother;

final class CreateCourseRequestMother
{
    public static function create(CourseId $id, CourseName $name, CourseDuration $duration): CreateCourseRequest
    {
        return new CreateCourseRequest($id->value(), $name->value(), $duration->value());
    }

    public static function random(): CreateCourseRequest
    {
        return self::create(
            CourseIdMother::random(),
            CourseNameMother::random(),
            CourseDurationMother::random());
    }
}
