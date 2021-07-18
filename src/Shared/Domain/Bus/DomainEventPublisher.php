<?php


namespace LuisCusihuaman\Shared\Domain\Bus;


interface DomainEventPublisher
{
    public function publish(DomainEvent ...$domainEvents);
}