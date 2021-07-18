<?php


namespace LuisCusihuaman\Shared\Domain;


interface UuidGenerator
{

    public function generate(): string;
}