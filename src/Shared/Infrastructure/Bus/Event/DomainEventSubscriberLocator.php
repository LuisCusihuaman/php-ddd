<?php

namespace LuisCusihuaman\Shared\Infrastructure\Bus\Event;

use LuisCusihuaman\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;

final class DomainEventSubscriberLocator
{
    private array $mapping;

    public function __construct(iterable $mapping)
    {
        $this->mapping = CallableFirstParameterExtractor::forPipedCallables($mapping);
    }

    public function for(string $eventClass): callable
    {
        return $this->mapping[$eventClass];
    }

    public function all(): array
    {
        return $this->mapping;
    }
}
