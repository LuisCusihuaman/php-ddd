<?php


namespace LuisCusihuaman\Shared\Domain\Bus\Event;


use DateTimeImmutable;
use LuisCusihuaman\Shared\Domain\Utils;
use LuisCusihuaman\Shared\Domain\ValueObject\Uuid;

abstract class DomainEvent
{
    private string $aggregateId;
    private string $eventId;
    private string $occurredOn;

    public function __construct(string $aggregateId, string $eventId = null, string $occurredOn = null)
    {
        $this->aggregateId = $aggregateId;
        $this->eventId = $eventId ?: Uuid::random()->value();
        $this->occurredOn = $occurredOn ?: Utils::dateToString(new DateTimeImmutable());
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }

    abstract public static function eventName(): string;

    abstract public function plainBody(): array;

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }
}