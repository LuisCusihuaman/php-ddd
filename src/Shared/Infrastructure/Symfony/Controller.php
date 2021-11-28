<?php

namespace LuisCusihuaman\Shared\Infrastructure\Symfony;

use LuisCusihuaman\Shared\Domain\Bus\Command\Command;
use LuisCusihuaman\Shared\Domain\Bus\Command\CommandBus;
use LuisCusihuaman\Shared\Domain\Bus\Query\Query;
use LuisCusihuaman\Shared\Domain\Bus\Query\QueryBus;
use LuisCusihuaman\Shared\Domain\Bus\Query\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Twig\Environment;

abstract class Controller
{
    private $twig;
    private $router;
    private $session;
    private $queryBus;
    private $commandBus;

    public function __construct(
        Environment      $twig,
        RouterInterface  $router,
        SessionInterface $session,
        QueryBus         $queryBus,
        CommandBus       $commandBus
    )
    {
        $this->twig = $twig;
        $this->router = $router;
        $this->session = $session;
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

    public function redirectWithErrors(string $routeName, ConstraintViolationListInterface $errors, Request $request): RedirectResponse
    {
        $this->addFlashFor('errors', $this->formatFlashErrors($errors));
        $this->addFlashFor('inputs', $request->request->all());

        return new RedirectResponse($this->router->generate($routeName), 302);
    }


    /**
     * Add messages to flash bag session
     * @param string $prefix
     * @param array $messages
     */
    private function addFlashFor(string $prefix, array $messages): void
    {
        foreach ($messages as $key => $message) {
            $typeMessage = $prefix . '.' . $key; #e.g: 'errors.id'
            $this->session->getFlashBag()->set($typeMessage, $message);
        }
    }

    /**
     * Format flash errors like [errors.id => 'message-error' ]
     * @param ConstraintViolationListInterface $violations
     * @return array
     */
    private function formatFlashErrors(ConstraintViolationListInterface $violations): array
    {
        $errors = [];
        foreach ($violations as $violation) {
            $key_html_form = str_replace(['[', ']'], ['', ''], $violation->getPropertyPath());
            $errors[$key_html_form] = $violation->getMessage();
        }

        return $errors;
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

