<?php


namespace LuisCusihuaman\Shared\Domain\Bus;


interface DomainEventSubscriber
{
    public static function subscribedTo(): array;
}