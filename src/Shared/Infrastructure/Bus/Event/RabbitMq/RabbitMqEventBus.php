<?php

namespace LuisCusihuaman\Shared\Infrastructure\Bus\Event\RabbitMq;

use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;
use LuisCusihuaman\Shared\Domain\Bus\Event\EventBus;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\DomainEventJsonSerializer;
use function Lambdish\Phunctional\each;

final class RabbitMqEventBus implements EventBus
{
    private RabbitMqConnection $connection;
    private string $exchangeName;

    public function __construct(RabbitMqConnection $connection, string $exchangeName)
    {
        $this->connection = $connection;
        $this->exchangeName = $exchangeName;
    }

    public function publish(DomainEvent ...$events): void
    {
        each($this->publisher(), $events);
    }

    private function publisher(): callable
    {
        return function (DomainEvent $event) {
            $serializedEventJson = DomainEventJsonSerializer::serialize($event);
            $routingKey = $event::eventName();
            $messageId = $event->eventId();

            $this->connection->exchange($this->exchangeName)->publish(
                $serializedEventJson, $routingKey, AMQP_NOPARAM,
                [
                    'message_id' => $messageId,
                    'content_type' => 'application/json',
                    'content_encoding' => 'utf-8',
                ]);
        };
    }
}