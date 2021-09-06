<?php

namespace LuisCusihuaman\Apps\Mooc\Backend\Command\DomainEvents\MySql;

use Doctrine\DBAL\Driver\Exception;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\DomainEventSubscriberLocator;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\MySql\MySqlDoctrineDomainEventsConsumer;
use LuisCusihuaman\Shared\Infrastructure\Doctrine\DatabaseConnections;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Lambdish\Phunctional\pipe;


//  php apps/mooc/backend/bin/console luiscusihuaman:mysql:consume <quantityEventsToProcess>
final class ConsumeMySqlDomainEventsCommand extends Command
{
    protected static $defaultName = 'luiscusihuaman:mysql:consume';
    private MySqlDoctrineDomainEventsConsumer $consumer;
    private DomainEventSubscriberLocator $subscriberLocator;
    private DatabaseConnections $connections;

    public function __construct(
        MySqlDoctrineDomainEventsConsumer $consumer,
        DatabaseConnections               $connections,
        DomainEventSubscriberLocator      $subscriberLocator
    )
    {
        $this->consumer = $consumer;
        $this->subscriberLocator = $subscriberLocator;
        $this->connections = $connections;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Consume domain events from MySql')
            ->addArgument('quantity', InputArgument::REQUIRED, 'Quantity of events to process');
    }

    private function consumer(): callable
    {
        return function (DomainEvent $domainEvent) {
            $subscribers = $this->subscriberLocator->for(get_class($domainEvent));
            foreach ($subscribers as $subscriber) {
                $subscriber($domainEvent);
            }
        };
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $quantityEventsToProcess = (int)$input->getArgument('quantity');

        $consumer = pipe($this->consumer(), fn() => $this->connections->clear());

        $this->consumer->consume($consumer, $quantityEventsToProcess);
    }
}