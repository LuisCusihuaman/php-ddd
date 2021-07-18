<?php


namespace LuisCusihuaman\Shared\Domain\Bus\Event;


interface DomainEventPublisher
{
    public function publish(DomainEvent ...$domainEvents);
}