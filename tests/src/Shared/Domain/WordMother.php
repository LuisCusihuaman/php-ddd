<?php


namespace LuisCusihuaman\Tests\Shared\Domain;


class WordMother
{
    public static function random(): string
    {
        return MotherCreator::random()->word;
    }
}