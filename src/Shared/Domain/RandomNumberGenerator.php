<?php


namespace LuisCusihuaman\Shared\Domain;


interface RandomNumberGenerator
{
    public function generate(): int;
}