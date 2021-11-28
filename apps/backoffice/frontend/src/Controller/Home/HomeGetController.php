<?php

declare(strict_types=1);

namespace LuisCusihuaman\Apps\Backoffice\Frontend\Controller\Home;

use LuisCusihuaman\Shared\Infrastructure\Symfony\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HomeGetController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return $this->render(
            'pages/home.html.twig',
            [
                'title' => 'Welcome',
                'description' => 'LuisCusihuaman - Backoffice',
            ]);
    }
}
