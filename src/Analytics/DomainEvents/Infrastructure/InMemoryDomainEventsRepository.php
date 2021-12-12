<?php

namespace LuisCusihuaman\Analytics\DomainEvents\Infrastructure;

use LuisCusihuaman\Analytics\DomainEvents\Domain\AnalyticsDomainEvent;
use LuisCusihuaman\Analytics\DomainEvents\Domain\DomainEventsRepository;

class InMemoryDomainEventsRepository implements DomainEventsRepository
{
    private array $events = [];

    public function save(AnalyticsDomainEvent $event): void
    {
        $this->events[$event->name()->value()] = $event->body()->value();
        echo $event->aggregateId();
    }
}
