<?php


namespace LuisCusihuaman\Tests\Mooc\Courses\Domain;


use LuisCusihuaman\Mooc\Courses\Domain\CourseDuration;
use LuisCusihuaman\Tests\Shared\Domain\IntegerMother;
use LuisCusihuaman\Tests\Shared\Domain\RandomElementPicker;

class CourseDurationMother
{

    public static function create(string $value): CourseDuration
    {
        return new CourseDuration($value);
    }

    public static function random(): CourseDuration
    {
        return self::create(
            sprintf(
                '%s %s',
                IntegerMother::random(),
                RandomElementPicker::from('months', 'years', 'days', 'hours', 'minutes', 'seconds')
            )
        );
    }
}