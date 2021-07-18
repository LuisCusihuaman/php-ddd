<?php


namespace LuisCusihuaman\Shared\Domain\Bus;


interface EventBus
{
    public function notify(DomainEvent $event): void;
}