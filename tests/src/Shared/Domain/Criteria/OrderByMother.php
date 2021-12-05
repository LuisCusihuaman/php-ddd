<?php

namespace LuisCusihuaman\Tests\Shared\Domain\Criteria;

use LuisCusihuaman\Shared\Domain\Criteria\OrderBy;
use LuisCusihuaman\Tests\Shared\Domain\WordMother;

final class OrderByMother
{
    public static function create($fieldName): OrderBy
    {
        return new OrderBy($fieldName);
    }

    public static function random(): OrderBy
    {
        return self::create(WordMother::random());
    }
}
