<?php

namespace LuisCusihuaman\Tests\Shared\Domain\Criteria;

use LuisCusihuaman\Shared\Domain\Criteria\OrderType;

final class OrderTypeMother
{
    public static function create($fieldName): OrderType
    {
        return new OrderType($fieldName);
    }

    public static function random(): OrderType
    {
        return self::create('desc');
    }
}
