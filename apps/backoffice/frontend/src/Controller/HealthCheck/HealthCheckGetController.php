<?php


namespace LuisCusihuaman\Apps\Backoffice\Frontend\Controller\HealthCheck;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HealthCheckGetController
{
    public function __invoke(Request $request): Response
    {
        return new JsonResponse(['backoffice-healthcheck' => 'ok']);
    }
}
