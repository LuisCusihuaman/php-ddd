<?php

namespace LuisCusihuaman\Shared\Domain\Criteria;

class Order
{
    private $orderBy;
    private $orderType;

    public function __construct(OrderBy $orderBy, OrderType $orderType)
    {
        $this->orderBy = $orderBy;
        $this->orderType = $orderType;
    }

    public static function fromValues(?string $orderBy, ?string $order): Order
    {
        return $orderBy === null ? self::none() : new Order(new OrderBy($orderBy), new OrderType($order));
    }

    private static function none(): Order
    {
        return new Order(new OrderBy(""), OrderType::none());
    }

    public function isNone(): bool
    {
        return $this->orderType()->isNone();
    }

    public function orderBy(): OrderBy
    {
        return $this->orderBy;
    }

    public function orderType(): OrderType
    {
        return $this->orderType;
    }
}
