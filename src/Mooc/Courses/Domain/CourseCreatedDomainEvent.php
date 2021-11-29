<?php


namespace LuisCusihuaman\Mooc\Courses\Domain;


use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;

final class CourseCreatedDomainEvent extends DomainEvent
{
    private string $name;
    private string $duration;

    public function __construct(
        string $id,
        string $name,
        string $duration,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($id, $eventId, $occurredOn);

        $this->name = $name;
        $this->duration = $duration;
    }

    public static function eventName(): string
    {
        return 'course.created';
    }

    public function toPrimitives(): array
    {
        return [
            'name' => $this->name,
            'duration' => $this->duration,
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array  $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent
    {
        return new self($aggregateId, $body['name'], $body['duration'], $eventId, $occurredOn);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function duration(): string
    {
        return $this->duration;

    }
}
