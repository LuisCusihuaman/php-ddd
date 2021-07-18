<?php


namespace LuisCusihuaman\Shared\Domain\Bus\Event;

use function Lambdish\Phunctional\each;

class SymfonySyncDomainEventPublisher implements DomainEventPublisher
{
    private array $events = [];
    private array $publishedEvents = [];

    public function record(DomainEvent ...$domainEvents): void
    {
        $this->events = array_merge($this->events, array_values($domainEvents));
    }

    public function publishRecorded(): void
    {
        each($this->eventPublisher(), $this->popEvents());
    }

    public function publish(DomainEvent ...$domainEvents): void
    {
        $this->record(...$domainEvents);

        $this->publishRecorded();
    }

    private function eventPublisher(): callable
    {
        return function (DomainEvent $event): void {
            $this->publishedEvents[] = $event;
        };
    }

    private function popEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    public function popPublishedEvents(): array
    {
        $events = $this->publishedEvents;
        $this->publishedEvents = [];

        return $events;
    }

    public function hasEventsToPublish(): bool
    {
        return count($this->publishedEvents) > 0;
    }
}
