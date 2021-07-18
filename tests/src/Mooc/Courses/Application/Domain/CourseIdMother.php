<?php


namespace LuisCusihuaman\Tests\Mooc\Courses\Application\Domain;


use LuisCusihuaman\Mooc\Courses\Domain\CourseId;
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
}
