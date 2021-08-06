<?php


namespace LuisCusihuaman\Tests\Shared\Infrastructure\Behat;


use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEventUnserializer;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\SymfonySyncDomainEventPublisher;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\SymfonySyncEventBus;
use LuisCusihuaman\Shared\Infrastructure\Doctrine\DatabaseConnections;
use function Lambdish\Phunctional\each;

class ApplicationFeatureContext implements Context
{
    private $connections;
    private $publisher;
    private $bus;
    private $unserializer;

    public function __construct(
        DatabaseConnections             $connections,
        SymfonySyncDomainEventPublisher $publisher,
        SymfonySyncEventBus             $bus,
        DomainEventUnserializer         $unserializer
    )
    {
        $this->connections = $connections;
        $this->publisher = $publisher;
        $this->bus = $bus;
        $this->unserializer = $unserializer;
    }

    /** @AfterScenario*/
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

    /**
     * @Given /^I send an event to the event bus:$/
     */
    public function iSendAnEventToTheEventBus(PyStringNode $event)
    {
        $domainEvent = $this->unserializer->unserialize($event->getRaw());

        $this->bus->notify($domainEvent);
    }
}