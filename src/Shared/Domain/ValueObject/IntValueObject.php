<?php


namespace LuisCusihuaman\Shared\Domain\ValueObject;


abstract class IntValueObject
{
    protected int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string)$this->value();
    }
}
