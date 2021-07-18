<?php


namespace LuisCusihuaman\Shared\Infrastructure\Bus\Event;


use LuisCusihuaman\Shared\Domain\Bus\DomainEvent;
use LuisCusihuaman\Shared\Domain\Bus\EventBus;
use LuisCusihuaman\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class SymfonySyncEventBus implements EventBus
{
    private $bus;

    public function __construct(iterable $subscribers)
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(
                        CallableFirstParameterExtractor::forPipedCallables($subscribers)
                    )
                ),
            ]
        );
    }

    public function notify(DomainEvent $event): void
    {
        $this->bus->dispatch($event);
    }
}