<?php


namespace LuisCusihuaman\Mooc\CoursesCounter\Domain;


use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;

class CoursesCounterIncrementedDomainEvent extends DomainEvent
{
    private int $total;

    public function __construct(string $aggregateId, int $total, string $eventId = null, string $occurredOn = null)
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);

        $this->total = $total;
    }

    public static function eventName(): string
    {
        return 'courses_counter.incremented';
    }

    public function toPrimitives(): array
    {
        return ['total' => $this->total];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent
    {
        return new self($aggregateId, $body['total'], $eventId, $occurredOn);
    }
}