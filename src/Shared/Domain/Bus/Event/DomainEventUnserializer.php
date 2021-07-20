<?php


namespace LuisCusihuaman\Shared\Domain\Bus\Event;


interface DomainEventUnserializer
{
    public function unserialize(string $domainEvent): DomainEvent;
}
