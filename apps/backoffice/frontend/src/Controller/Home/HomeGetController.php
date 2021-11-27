<?php

declare(strict_types=1);

namespace LuisCusihuaman\Apps\Backoffice\Frontend\Controller\Home;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class HomeGetController
{
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(Request $request): Response
    {
        return new Response($this->twig->render(
            'pages/home.html.twig',
            [
                'title' => 'Welcome',
                'description' => 'LuisCusihuaman - Backoffice',
            ]));
    }
}
