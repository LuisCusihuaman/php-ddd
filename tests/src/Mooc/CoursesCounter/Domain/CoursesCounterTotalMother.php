<?php


namespace LuisCusihuaman\Tests\Mooc\CoursesCounter\Domain;


use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounterTotal;
use LuisCusihuaman\Tests\Shared\Domain\IntegerMother;

final class CoursesCounterTotalMother
{
    public static function create(int $value): CoursesCounterTotal
    {
        return new CoursesCounterTotal($value);
    }

    public static function one(): CoursesCounterTotal
    {
        return self::create(1);
    }

    public static function random(): CoursesCounterTotal
    {
        return self::create(IntegerMother::random());
    }
}