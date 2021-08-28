<?php

namespace LuisCusihuaman\Shared\Infrastructure\Bus\Event\RabbitMq;

use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEventSubscriber;
use function Lambdish\Phunctional\each;

final class RabbitMqConfigurer
{
    private RabbitMqConnection $connection;

    public function __construct(RabbitMqConnection $connection)
    {
        $this->connection = $connection;
    }

    private function declareExchange(string $exchangeName): void
    {
        $exchange = $this->connection->exchange($exchangeName);
        $exchange->setType(AMQP_EX_TYPE_TOPIC);
        $exchange->setFlags(AMQP_DURABLE);
        $exchange->declareExchange();
    }

    private function declareQueues(string $exchangeName, DomainEventSubscriber ...$subscribers): void
    {
        $declareQueueOf = $this->queueDeclarator($exchangeName);
        each($declareQueueOf, $subscribers);
    }

    public function configure(string $exchangeName, DomainEventSubscriber  ...$subscribers): void
    {
        $this->declareExchange($exchangeName);
        $this->declareQueues($exchangeName, ...$subscribers);
    }

    private function queueDeclarator(string $exchangeName): callable
    {
        return function (DomainEventSubscriber $subscriber) use ($exchangeName) {
            $queueName = RabbitMqQueueNameFormatter::format($subscriber);

            $queue = $this->connection->queue($queueName);
            $queue->setFlags(AMQP_DURABLE);
            $queue->declareQueue();

            foreach ($subscriber::subscribedTo() as $eventClass) {
                $queue->bind($exchangeName, $eventClass::eventName());
            }
        };
    }
}