<?php


namespace LuisCusihuaman\Tests\Shared\Infrastructure\Behat;


use Behat\Behat\Context\Context;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;
use LuisCusihuaman\Shared\Domain\Bus\Event\SymfonySyncDomainEventPublisher;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\SymfonySyncEventBus;
use LuisCusihuaman\Tests\Shared\Infrastructure\Doctrine\DatabaseConnections;
use function Lambdish\Phunctional\each;

class ApplicationFeatureContext implements Context
{
    private $connections;
    private $publisher;
    private $bus;

    public function __construct(
        DatabaseConnections $connections,
        SymfonySyncDomainEventPublisher $publisher,
        SymfonySyncEventBus $bus
    )
    {
        $this->connections = $connections;
        $this->publisher = $publisher;
        $this->bus = $bus;
    }

    /** @BeforeScenario */
    public function cleanEnvironment(): void
    {
        $this->connections->clear();
        $this->connections->truncate();
    }

    /** @AfterStep */
    public function publishEvents(): void
    {
        while ($this->publisher->hasEventsToPublish()) {
            each(
                fn(DomainEvent $event) => $this->bus->notify($event),
                $this->publisher->popPublishedEvents()
            );
        }
    }
}