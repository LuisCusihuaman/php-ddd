<?php

namespace LuisCusihuaman\Shared\Infrastructure\Symfony;

use LuisCusihuaman\Shared\Domain\Bus\Command\Command;
use LuisCusihuaman\Shared\Domain\Bus\Command\CommandBus;
use LuisCusihuaman\Shared\Domain\Bus\Query\Query;
use LuisCusihuaman\Shared\Domain\Bus\Query\QueryBus;
use LuisCusihuaman\Shared\Domain\Bus\Query\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

abstract class Controller
{
    private $twig;
    private $queryBus;
    private $commandBus;
    private $router;

    public function __construct(Environment $twig, RouterInterface $router, QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->twig = $twig;
        $this->router = $router;
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function render(string $templatePath, array $arguments = []): SymfonyResponse
    {
        return new SymfonyResponse($this->twig->render($templatePath, $arguments));
    }

    public function redirect(string $routeName): RedirectResponse
    {
        return new RedirectResponse($this->router->generate($routeName), 302);
    }

    public function ask(Query $query): ?Response
    {
        return $this->queryBus->ask($query);
    }

    public function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}

