<?php


namespace LuisCusihuaman\Shared\Infrastructure\Bus\Event\InMemory;


use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;
use LuisCusihuaman\Shared\Domain\Bus\Event\EventBus;
use LuisCusihuaman\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class InMemorySymfonyEventBus implements EventBus
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

    public function publish(DomainEvent ...$events): void
    {
        try {
            foreach ($events as $event){
                $this->bus->dispatch($event);
            }
        } catch (NoHandlerForMessageException $error) {
        }
    }
}