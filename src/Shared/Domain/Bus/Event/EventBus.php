<?php


namespace LuisCusihuaman\Shared\Domain\Bus\Event;


interface EventBus
{
    public function notify(DomainEvent $event): void;
}