<?php


namespace LuisCusihuaman\Tests\Shared\Domain;


class UuidMother
{
    public static function random(): string
    {
        return MotherCreator::random()->unique()->uuid;
    }
}