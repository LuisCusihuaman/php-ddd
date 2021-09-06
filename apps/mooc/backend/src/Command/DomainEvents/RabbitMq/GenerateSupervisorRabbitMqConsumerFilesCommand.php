<?php

namespace LuisCusihuaman\Apps\Mooc\Backend\Command\DomainEvents\RabbitMq;

use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEventSubscriber;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\DomainEventSubscriberLocator;
use LuisCusihuaman\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqQueueNameFormatter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Lambdish\Phunctional\each;

//  php apps/mooc/backend/bin/console luiscusihuaman:rabbitmq:generate-supervisor-files <OPT: path>
final class GenerateSupervisorRabbitMqConsumerFilesCommand extends Command
{
    protected static $defaultName = 'luiscusihuaman:rabbitmq:generate-supervisor-files';

    private const EVENTS_TO_PROCESS_AT_TIME = 200;
    private const NUMBERS_OF_PROCESSES_PER_SUBSCRIBER = 1;
    private const SUPERVISOR_PATH = __DIR__ . '/../../../build/supervisor';
    private DomainEventSubscriberLocator $locator;

    public function __construct(DomainEventSubscriberLocator $locator)
    {
        parent::__construct();
        $this->locator = $locator;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Generate the supervisor configuration for every RabbitMQ subscriber')
            ->addArgument('command-path', InputArgument::OPTIONAL, 'Path on this is gonna be deployed', '/var/www');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = (string)$input->getArgument('command-path');
        each($this->configCreator($path), $this->locator->all());
    }

    private function configCreator(string $path): callable
    {
        return function (DomainEventSubscriber $subscriber) use ($path) {
            $queueName = RabbitMqQueueNameFormatter::format($subscriber);
            $subscriberName = RabbitMqQueueNameFormatter::shortFormat($subscriber);

            $fileContent = str_replace(
                [
                    '{subscriber_name}',
                    '{queue_name}',
                    '{path}',
                    '{processes}',
                    '{events_to_process}',
                ],
                [
                    $subscriberName,
                    $queueName,
                    $path,
                    self::NUMBERS_OF_PROCESSES_PER_SUBSCRIBER,
                    self::EVENTS_TO_PROCESS_AT_TIME
                ],
                $this->template()
            );

            file_put_contents($this->fileName($subscriberName), $fileContent);
        };
    }

    private function template(): string
    {
        return <<<EOF
[program:luiscusihuaman_{queue_name}]
command      = {path}/apps/mooc/backend/bin/console luiscusihuaman:rabbitmq:consume --env=prod {queue_name} {events_to_process}
process_name = %(program_name)s_%(process_num)02d
numprocs     = {processes}
startsecs    = 1
startretries = 10
exitcodes    = 2
stopwaitsecs = 300
autostart    = true
EOF;
    }

    private function fileName(string $queue): string
    {
        return sprintf('%s/%s.ini', self::SUPERVISOR_PATH, $queue);
    }
}
