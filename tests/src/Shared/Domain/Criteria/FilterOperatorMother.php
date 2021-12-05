<?php

namespace LuisCusihuaman\Tests\Shared\Domain\Criteria;

use LuisCusihuaman\Shared\Domain\Criteria\FilterOperator;

class FilterOperatorMother
{
    public static function create($value): FilterOperator
    {
        return new FilterOperator($value);
    }

    public static function random(): FilterOperator
    {
        return self::create("=");
    }
}

