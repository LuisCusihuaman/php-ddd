<?php

namespace LuisCusihuaman\Shared\Infrastructure\Bus\Event;

use LuisCusihuaman\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use Traversable;

final class DomainEventSubscriberLocator
{
    private $mapping;

    public function __construct(Traversable $mapping)
    {
        $this->mapping = iterator_to_array($mapping);
    }

    public function for(string $eventClass): array
    {
        $formatted = CallableFirstParameterExtractor::forPipedCallables($this->mapping);
        $callables = $formatted[$eventClass];
        return $callables;
    }

    public function all(): array
    {
        return $this->mapping;
    }
}
