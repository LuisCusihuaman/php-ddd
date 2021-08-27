<?php


namespace LuisCusihuaman\Shared\Domain\Bus\Event;


interface EventBus
{
    public function publish(DomainEvent ...$events): void;
}