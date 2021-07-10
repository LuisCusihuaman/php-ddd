<?php


namespace LuisCusihuaman\Tests\Shared\Domain;


final class RandomElementPicker
{
    public static function from(...$elements)
    {
        return MotherCreator::random()->randomElement($elements);
    }
}