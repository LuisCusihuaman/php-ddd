<?php


namespace LuisCusihuaman\Shared\Infrastructure\Bus\Event;


use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEventSubscriber;
use function Lambdish\Phunctional\reduce;
use function Lambdish\Phunctional\reindex;

final class DomainEventMapping
{
    private $mapping;

    public function __construct(iterable $mapping)
    {
        $this->mapping = reduce($this->eventsExtractor(), $mapping, []);
    }

    public function for(string $name)
    {
        return $this->mapping[$name];
    }

    public function all()
    {
        return $this->mapping;
    }

    private function eventsExtractor(): callable
    {
        return function (array $mapping, DomainEventSubscriber $subscriber) {
            return array_merge($mapping, reindex($this->eventNameExtractor(), $subscriber::subscribedTo()));
        };
    }

    private function eventNameExtractor(): callable
    {
        return static fn(DomainEvent $event) => $event::eventName();
    }
}