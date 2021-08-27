<?php

namespace LuisCusihuaman\Shared\Infrastructure\Bus\Event\MySql;

use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\ORM\EntityManager;
use LuisCusihuaman\Shared\Domain\Utils;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\DomainEventMapping;
use RuntimeException;
use function Lambdish\Phunctional\each;
use function Lambdish\Phunctional\map;


class MySqlDoctrineDomainEventsConsumer
{

    private Connection $connection;
    private DomainEventMapping $eventMapping;

    public function __construct(EntityManager $entityManager, DomainEventMapping $eventMapping)
    {
        $this->connection = $entityManager->getConnection();
        $this->eventMapping = $eventMapping;
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws Exception
     */
    public function consume(callable $subscriber, int $eventsToConsume): void
    {
        $query = "SELECT * FROM domain_events ORDER BY occurred_on LIMIT $eventsToConsume;";
        $events = $this->connection->executeQuery($query)->fetchAllAssociative();

        // Execute every subscribers that is subscribed to specific event
        each($this->executeSubscriber($subscriber), $events);
        $ids = implode(', ', map($this->idExtractor(), $events));
        if ($ids !== "") {
            $this->connection->executeStatement("DELETE FROM domain_events WHERE id IN($ids)");
        }
    }

    private function executeSubscriber(callable $subscriber): callable
    {
        return function (array $rawEvent) use ($subscriber) {
            try {
                $domainEventClass = $this->eventMapping->for($rawEvent['name']);
                $domainEvent = $domainEventClass::fromPrimitives(
                    $rawEvent['aggregate_id'],
                    Utils::jsonDecode($rawEvent['body']),
                    $rawEvent['id'],
                    $this->formatDate($rawEvent['occurred_on'])
                );

                $subscriber($domainEvent);
            } catch (RuntimeException $error) {
            }
        };
    }

    /**
     * @throws \Exception
     */
    private function formatDate($stringDate): string
    {
        return Utils::dateToString(new DateTimeImmutable($stringDate));
    }

    private function idExtractor(): callable
    {
        return static function (array $event) {
            return "'${event['id']}'";
        };
    }
}