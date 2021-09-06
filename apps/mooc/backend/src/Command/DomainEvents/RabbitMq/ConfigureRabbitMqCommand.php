<?php

namespace LuisCusihuaman\Apps\Mooc\Backend\Command\DomainEvents\RabbitMq;

use LuisCusihuaman\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqConfigurer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Traversable;

//  php apps/mooc/backend/bin/console luiscusihuaman:rabbitmq:configure
final class ConfigureRabbitMqCommand extends Command
{
    protected static $defaultName = 'luiscusihuaman:rabbitmq:configure';
    private RabbitMqConfigurer $configurer;
    private string $exchangeName;
    private Traversable $subscribers;

    public function __construct(RabbitMqConfigurer $configurer, string $exchangeName, Traversable $subscribers)
    {
        parent::__construct();

        $this->configurer = $configurer;
        $this->exchangeName = $exchangeName;
        $this->subscribers = $subscribers;
    }

    protected function configure()
    {
        $this->setDescription('Configure the RabbitMq to allow publish & consume domain events');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $domainEventSubscribers = iterator_to_array($this->subscribers);
        $this->configurer->configure($this->exchangeName, ...$domainEventSubscribers);
        echo "RabbitMQ configurated!\n";
    }
}