<?php


namespace LuisCusihuaman\Mooc\Courses\Domain;


use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;

final class CourseCreatedDomainEvent extends DomainEvent
{
    private string $name;
    private string $duration;

    public function __construct(string $id, string $name, string $duration)
    {
        parent::__construct($id);

        $this->name = $name;
        $this->duration = $duration;
    }

    public static function eventName(): string
    {
        return 'course.created';
    }

    public function plainBody(): array
    {
        return [
            'name' => $this->name,
            'duration' => $this->duration,
        ];
    }
}