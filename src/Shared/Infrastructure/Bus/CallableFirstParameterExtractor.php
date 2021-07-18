<?php

declare(strict_types=1);

namespace LuisCusihuaman\Shared\Infrastructure\Bus;

use LuisCusihuaman\Shared\Domain\Bus\DomainEventSubscriber;
use function Lambdish\Phunctional\reduce;

final class CallableFirstParameterExtractor
{
    public static function forPipedCallables(iterable $callables): array
    {
        return reduce(self::pipedCallablesReducer(), $callables, []);
    }

    private static function pipedCallablesReducer(): callable
    {
        return static function ($subscribers, DomainEventSubscriber $subscriber): array {
            $subscribedEvents = $subscriber::subscribedTo();

            foreach ($subscribedEvents as $subscribedEvent) {
                $subscribers[$subscribedEvent][] = $subscriber;
            }

            return $subscribers;
        };
    }
}
