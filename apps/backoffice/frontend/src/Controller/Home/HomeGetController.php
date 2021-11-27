<?php

declare(strict_types=1);

namespace LuisCusihuaman\Apps\Backoffice\Frontend\Controller\Home;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HomeGetController
{

    public function __invoke(Request $request): Response
    {
        return new JsonResponse(['backoffice-home!' => 'ok']);
    }
}
