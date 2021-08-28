<?php

namespace LuisCusihuaman\Apps\Mooc\Backend\Command\RabbitMq;

use LuisCusihuaman\Shared\Infrastructure\Bus\Event\DomainEventSubscriberLocator;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqDomainEventsConsumer;
use LuisCusihuaman\Shared\Infrastructure\Doctrine\DatabaseConnections;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Lambdish\Phunctional\repeat;

//  php apps/mooc/backend/bin/console luiscusihuaman:rabbitmq:consume <queueName> <quantityEventsToProcess>
final class ConsumeRabbitMqDomainEventsCommand extends Command
{
    protected static $defaultName = 'luiscusihuaman:rabbitmq:consume';
    private RabbitMqDomainEventsConsumer $consumer;
    private DatabaseConnections $connections;
    private DomainEventSubscriberLocator $locator;

    public function __construct(
        RabbitMqDomainEventsConsumer $consumer,
        DatabaseConnections          $connections,
        DomainEventSubscriberLocator $locator
    )
    {
        parent::__construct();

        $this->consumer = $consumer;
        $this->connections = $connections;
        $this->locator = $locator;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Consume domain events from the RabbitMQ')
            ->addArgument('queue', InputArgument::REQUIRED, 'Queue name')
            ->addArgument('quantity', InputArgument::REQUIRED, 'Quantity of events to process');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $queueName = (string)$input->getArgument('queue');
        $eventsToProcess = (int)$input->getArgument('quantity');

        repeat($this->consumer($queueName), $eventsToProcess);
    }

    private function consumer(string $queueName): callable
    {
        return function () use ($queueName) {
            $subscriber = $this->locator->withRabbitMqQueueNamed($queueName);

            $this->consumer->consume($subscriber, $queueName);

            $this->connections->clear();
        };

    }
}