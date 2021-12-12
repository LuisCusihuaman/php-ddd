<?php

namespace LuisCusihuaman\Analytics\DomainEvents\Domain;

final class AnalyticsDomainEventBody
{
    private $value;

    public function __construct(array $value)
    {
        $this->value = $value;
    }

    public function value(): array
    {
        return $this->value;
    }
}
