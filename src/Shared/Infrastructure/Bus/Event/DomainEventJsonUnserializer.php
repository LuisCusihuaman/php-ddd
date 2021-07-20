<?php


namespace LuisCusihuaman\Shared\Infrastructure\Bus\Event;


use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEventUnserializer;
use LuisCusihuaman\Shared\Domain\Utils;
use RuntimeException;

final class DomainEventJsonUnserializer implements DomainEventUnserializer
{
    private $mapping;

    public function __construct(DomainEventMapping $mapping)
    {
        $this->mapping = $mapping;
    }

    public function unserialize(string $domainEvent): DomainEvent
    {
        $eventData = Utils::jsonDecode($domainEvent);
        $eventName = $eventData['data']['type'];
        $eventClass = $this->mapping->for($eventName);

        if (null === $eventClass) {
            throw new RuntimeException("The event <$eventName> doesn't exist or has no subscribers");
        }

        return $eventClass::fromPrimitives(
            $eventData['data']['attributes']['id'],
            $eventData['data']['attributes'],
            $eventData['data']['id'],
            $eventData['data']['occurred_on']
        );
    }
}
