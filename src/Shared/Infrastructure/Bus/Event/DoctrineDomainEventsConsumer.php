<?php

namespace LuisCusihuaman\Shared\Infrastructure\Bus\Event;

use DateTimeImmutable;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\ORM\EntityManager;
use LuisCusihuaman\Shared\Domain\Utils;
use RuntimeException;
use function Lambdish\Phunctional\each;
use function Lambdish\Phunctional\map;

class DoctrineDomainEventsConsumer
{

    private EntityManager $entityManager;
    private DomainEventMapping $eventMapping;

    public function __construct(EntityManager $entityManager, DomainEventMapping $eventMapping)
    {
        $this->entityManager = $entityManager;
        $this->eventMapping = $eventMapping;
    }

    public function consume(callable $subscriber, int $totalEvents): void
    {
        $connection = $this->entityManager->getConnection();
        $query = "SELECT * FROM domain_events ORDER BY occurred_on ASC LIMIT $totalEvents";
        $events = $connection->executeQuery($query)->fetchAllAssociative();

        each($this->executeSubscriber($subscriber), $events);
        $ids = implode(', ', map(fn(array $events) => "'${events['id']}'", $events));
        $connection->executeStatement("DELETE FROM domain_events WHERE id IN ($ids)");
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
}