<?php

namespace LuisCusihuaman\Tests\Shared\Domain\Criteria;

use LuisCusihuaman\Shared\Domain\Criteria\Criteria;
use LuisCusihuaman\Shared\Domain\Criteria\Filters;
use LuisCusihuaman\Shared\Domain\Criteria\Order;
use LuisCusihuaman\Tests\Shared\Domain\IntegerMother;

final class CriteriaMother
{
    public static function create(Filters $filters, Order $order = null, int $offset = null, int $limit = null): Criteria
    {
        return new Criteria($filters, $order ?: OrderMother::none(), $offset, $limit);
    }

    public static function empty(): Criteria
    {
        return self::create(FiltersMother::blank(), OrderMother::none());
    }

    public static function random(): Criteria
    {
        return self::create(
            FiltersMother::random(),
            OrderMother::random(),
            IntegerMother::random(),
            IntegerMother::random()
        );
    }
}
