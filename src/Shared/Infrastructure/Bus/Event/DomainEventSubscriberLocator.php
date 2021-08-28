<?php

namespace LuisCusihuaman\Shared\Infrastructure\Bus\Event;

use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEventSubscriber;
use LuisCusihuaman\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqQueueNameFormatter;
use RuntimeException;
use Traversable;
use function Lambdish\Phunctional\search;

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

    public function withRabbitMqQueueNamed(string $queueName): callable
    {
        $subscriber = search(fn(DomainEventSubscriber $subscriber) => RabbitMqQueueNameFormatter::format($subscriber) === $queueName,
            $this->mapping);

        if ($subscriber == null) {
            throw new RuntimeException("There are no subscribers for the <$queueName> queue");
        }
        return $subscriber;
    }

    public function all(): array
    {
        return $this->mapping;
    }
}
