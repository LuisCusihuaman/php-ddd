<?php

namespace LuisCusihuaman\Analytics\DomainEvents\Application\Store;

use LuisCusihuaman\Analytics\DomainEvents\Domain\AnalyticsDomainEventAggregateId;
use LuisCusihuaman\Analytics\DomainEvents\Domain\AnalyticsDomainEventBody;
use LuisCusihuaman\Analytics\DomainEvents\Domain\AnalyticsDomainEventId;
use LuisCusihuaman\Analytics\DomainEvents\Domain\AnalyticsDomainEventName;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEventSubscriber;

// It must be autowired in the app/services.yml that will launch towards the inmemory-bus
final class StoreDomainEventOnOccurred implements DomainEventSubscriber
{
    private $storer;

    public function __construct(DomainEventStorer $storer)
    {
        $this->storer = $storer;
    }

    public static function subscribedTo(): array
    {
        return [DomainEvent::class]; // subscribed to all events of domains that inherit from it
    }

    public function __invoke(DomainEvent $event)
    {
        $id = new AnalyticsDomainEventId($event->eventId());
        $aggregateId = new AnalyticsDomainEventAggregateId($event->aggregateId());
        $name = new AnalyticsDomainEventName($event::eventName());
        $body = new AnalyticsDomainEventBody($event->toPrimitives());

        $this->storer->store($id, $aggregateId, $name, $body);
    }
}
