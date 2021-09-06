<?php

namespace LuisCusihuaman\Shared\Infrastructure\Bus\Event\RabbitMq;

use AMQPException;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;
use LuisCusihuaman\Shared\Domain\Bus\Event\EventBus;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\DomainEventJsonSerializer;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\MySql\MySqlDoctrineEventBus;
use function Lambdish\Phunctional\each;

final class RabbitMqEventBus implements EventBus
{
    private RabbitMqConnection $connection;
    private string $exchangeName;
    private MySqlDoctrineEventBus $failoverPublisher;

    public function __construct(
        RabbitMqConnection    $connection,
        string                $exchangeName,
        MySqlDoctrineEventBus $failoverPublisher
    )
    {
        $this->connection = $connection;
        $this->exchangeName = $exchangeName;
        $this->failoverPublisher = $failoverPublisher;
    }

    public function publish(DomainEvent ...$events): void
    {
        each($this->publisher(), $events);
    }

    private function publisher(): callable
    {
        return function (DomainEvent $event) {
            try {
                $this->publishEvent($event);
            } catch (AMQPException $error) {
                $this->failoverPublisher->publish($event);
            }
        };
    }

    private function publishEvent(DomainEvent $event): void
    {
        $body = DomainEventJsonSerializer::serialize($event);
        $messageId = $event->eventId();
        $routingKey = $event::eventName();

        $this->connection->exchange($this->exchangeName)->publish(
            $body, $routingKey, AMQP_NOPARAM,
            [
                'message_id' => $messageId,
                'content_type' => 'application/json',
                'content_encoding' => 'utf-8',
            ]
        );
    }
}