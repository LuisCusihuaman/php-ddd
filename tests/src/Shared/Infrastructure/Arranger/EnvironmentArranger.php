<?php


namespace LuisCusihuaman\Tests\Shared\Infrastructure\Arranger;


interface EnvironmentArranger
{
    public function arrange(): void;

    public function close(): void;
}
