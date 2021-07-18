<?php


namespace LuisCusihuaman\Tests\Mooc\CoursesCounter\Domain;


use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounterId;
use LuisCusihuaman\Tests\Shared\Domain\UuidMother;

final class CourseCounterIdMother
{
    public static function create(string $value): CoursesCounterId
    {
        return new CoursesCounterId($value);
    }

    public static function random(): CoursesCounterId
    {
        return self::create(UuidMother::random());
    }
}