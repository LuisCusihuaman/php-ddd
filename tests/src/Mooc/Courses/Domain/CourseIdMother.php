<?php


namespace LuisCusihuaman\Tests\Mooc\Courses\Domain;


use LuisCusihuaman\Mooc\Shared\Domain\Course\CourseId;
use LuisCusihuaman\Tests\Shared\Domain\UuidMother;

class CourseIdMother
{

    public static function create(string $value): CourseId
    {
        return new CourseId($value);
    }

    public static function random(): CourseId
    {
        return self::create(UuidMother::random());
    }

    public static function creator(): callable
    {
        return static fn() => self::random();
    }
}
