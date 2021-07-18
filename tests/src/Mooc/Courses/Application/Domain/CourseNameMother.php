<?php


namespace LuisCusihuaman\Tests\Mooc\Courses\Application\Domain;

use LuisCusihuaman\Mooc\Courses\Domain\CourseName;
use LuisCusihuaman\Tests\Shared\Domain\WordMother;

class CourseNameMother
{

    public static function create(string $value): CourseName
    {
        return new CourseName($value);
    }

    public static function random(): CourseName
    {
        return self::create(WordMother::random());
    }
}