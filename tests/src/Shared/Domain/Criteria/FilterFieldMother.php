<?php

namespace LuisCusihuaman\Tests\Shared\Domain\Criteria;

use LuisCusihuaman\Shared\Domain\Criteria\FilterField;
use LuisCusihuaman\Tests\Shared\Domain\WordMother;

final class FilterFieldMother
{
    public static function create($fieldName): FilterField
    {
        return new FilterField($fieldName);
    }

    public static function random(): FilterField
    {
        return self::create(WordMother::random());
    }
}
