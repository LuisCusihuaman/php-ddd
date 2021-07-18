<?php


namespace LuisCusihuaman\Shared\Domain\Bus\Event;


interface DomainEventSubscriber
{
    public static function subscribedTo(): array;
}