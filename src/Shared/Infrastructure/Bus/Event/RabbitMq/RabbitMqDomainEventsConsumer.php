<?php

namespace LuisCusihuaman\Shared\Infrastructure\Bus\Event\RabbitMq;

use AMQPEnvelope;
use AMQPQueue;
use AMQPQueueException;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\DomainEventJsonDeserializer;
use Throwable;
use function Lambdish\Phunctional\assoc;
use function Lambdish\Phunctional\get;

final class RabbitMqDomainEventsConsumer
{
    private $connection;
    private $deserializer;
    private $exchangeName;
    private $maxRetries;

    public function __construct(
        RabbitMqConnection          $connection,
        DomainEventJsonDeserializer $deserializer,
        string                      $exchangeName,
        int                         $maxRetries
    )
    {
        $this->connection = $connection;
        $this->deserializer = $deserializer;
        $this->exchangeName = $exchangeName;
        $this->maxRetries = $maxRetries;
    }

    private function consumer(callable $subscriber): callable
    {
        return function (AMQPEnvelope $envelope, AMQPQueue $queue) use ($subscriber) {
            $event = $this->deserializer->deserialize($envelope->getBody());
            try {
                $subscriber($event);
            } catch (Throwable $error) {
                $this->handleConsumptionError($envelope, $queue);
                throw $error;
            }

            $queue->ack($envelope->getDeliveryTag());
        };
    }

    public function consume(callable $subscriber, string $queueName): void
    {
        try {
            $consumeBySubscriber = $this->consumer($subscriber);
            $this->connection->queue($queueName)->consume($consumeBySubscriber);

        } catch (AMQPQueueException $error) {
            // There is a buf with the amqp-1.9.4 version that throws a non-existing error with php 7
            // We don't want to raise an error it there are no messages on the queue
            // Usually AMQPQueueException: Consumer timeout exceed in e.g: test time
        }
    }

    private function handleConsumptionError(AMQPEnvelope $envelope, AMQPQueue $queue): void
    {
        $this->hasBeenRedeliveredTooMuch($envelope)
            ? $this->sendToDeadLetter($envelope, $queue)
            : $this->sendToRetry($envelope, $queue);

        $queue->ack($envelope->getDeliveryTag());
    }

    private function hasBeenRedeliveredTooMuch(AMQPEnvelope $envelope): bool
    {
        return get('redelivery_count', $envelope->getHeaders(), 0) >= $this->maxRetries;
    }

    private function sendToDeadLetter(AMQPEnvelope $envelope, AMQPQueue $queue): void
    {
        $this->sendMessageTo(RabbitMqExchangeNameFormatter::deadLetter($this->exchangeName),
            $envelope, $queue);
    }

    private function sendToRetry(AMQPEnvelope $envelope, AMQPQueue $queue): void
    {
        $this->sendMessageTo(RabbitMqExchangeNameFormatter::retry($this->exchangeName),
            $envelope, $queue);
    }

    private function sendMessageTo(string $exchangeName, AMQPEnvelope $envelope, AMQPQueue $queue): void
    {
        $headers = $envelope->getHeaders();
        $routingKey = $queue->getName();

        $this->connection->exchange($exchangeName)->publish(
            $envelope->getBody(), $routingKey, AMQP_NOPARAM,
            [
                'message_id' => $envelope->getMessageId(),
                'content_type' => $envelope->getContentType(),
                'content_encoding' => $envelope->getContentEncoding(),
                'priority' => $envelope->getPriority(),
                'headers' => assoc($headers, 'redelivery_count', get('redelivery_count', $headers, 0) + 1),
            ]
        );
    }
}