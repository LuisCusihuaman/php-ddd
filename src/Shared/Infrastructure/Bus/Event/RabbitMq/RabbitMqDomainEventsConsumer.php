<?php

namespace LuisCusihuaman\Shared\Infrastructure\Bus\Event\RabbitMq;

use AMQPEnvelope;
use AMQPQueue;
use AMQPQueueException;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\DomainEventJsonDeserializer;

final class RabbitMqDomainEventsConsumer
{
    private RabbitMqConnection $connection;
    private DomainEventJsonDeserializer $deserializer;

    public function __construct(RabbitMqConnection $connection, DomainEventJsonDeserializer $deserializer)
    {
        $this->connection = $connection;
        $this->deserializer = $deserializer;
    }

    private function consumer(callable $subscriber): callable
    {
        return function (AMQPEnvelope $envelope, AMQPQueue $queue) use ($subscriber) {
            $event = $this->deserializer->deserialize($envelope->getBody());
            $subscriber($event);
            $queue->ack($envelope->getDeliveryTag());
        };
    }

    public function consume(callable $subscriber, string $queueName): void
    {
        try {
            $this->connection->queue($queueName)
                ->consume($this->consumer($subscriber));
        } catch (AMQPQueueException $error) {
            // There is a buf with the amqp-1.9.4 version that throws a non-existing error with php 7
            // Usually AMQPQueueException: Consumer timeout exceed in e.g: test time
        }
    }
}