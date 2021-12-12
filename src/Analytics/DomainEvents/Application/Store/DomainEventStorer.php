<?php

namespace LuisCusihuaman\Analytics\DomainEvents\Application\Store;

use LuisCusihuaman\Analytics\DomainEvents\Domain\AnalyticsDomainEvent;
use LuisCusihuaman\Analytics\DomainEvents\Domain\AnalyticsDomainEventAggregateId;
use LuisCusihuaman\Analytics\DomainEvents\Domain\AnalyticsDomainEventBody;
use LuisCusihuaman\Analytics\DomainEvents\Domain\AnalyticsDomainEventId;
use LuisCusihuaman\Analytics\DomainEvents\Domain\AnalyticsDomainEventName;
use LuisCusihuaman\Analytics\DomainEvents\Domain\DomainEventsRepository;

final class DomainEventStorer
{
    private $repository;

    public function __construct(DomainEventsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(
        AnalyticsDomainEventId          $id,
        AnalyticsDomainEventAggregateId $aggregateId,
        AnalyticsDomainEventName        $name,
        AnalyticsDomainEventBody        $body
    ): void
    {
        $domainEvent = new AnalyticsDomainEvent($id, $aggregateId, $name, $body);

        $this->repository->save($domainEvent);
    }
}
