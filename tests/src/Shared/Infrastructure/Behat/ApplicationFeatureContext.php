<?php


namespace LuisCusihuaman\Tests\Shared\Infrastructure\Behat;


use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\DomainEventJsonDeserializer;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\InMemory\InMemorySymfonyEventBus;
use LuisCusihuaman\Shared\Infrastructure\Doctrine\DatabaseConnections;

class ApplicationFeatureContext implements Context
{
    private $connections;
    private $bus;
    private $unserializer;

    public function __construct(
        DatabaseConnections         $connections,
        InMemorySymfonyEventBus     $bus,
        DomainEventJsonDeserializer $unserializer
    )
    {
        $this->connections = $connections;
        $this->bus = $bus;
        $this->unserializer = $unserializer;
    }

    /** @AfterScenario */
    public function cleanEnvironment(): void
    {
        $this->connections->clear();
        $this->connections->truncate();
    }

    /**
     * @Given /^I send an event to the event bus:$/
     */
    public function iSendAnEventToTheEventBus(PyStringNode $event)
    {
        $domainEvent = $this->unserializer->deserialize($event->getRaw());

        $this->bus->publish($domainEvent);
    }
}