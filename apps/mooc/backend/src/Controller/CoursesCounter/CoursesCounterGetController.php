<?php


namespace LuisCusihuaman\Apps\Mooc\Backend\Controller\CoursesCounter;


use LuisCusihuaman\Mooc\CoursesCounter\Application\Find\CoursesCounterFinder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CoursesCounterGetController
{
    private CoursesCounterFinder $finder;

    public function __construct(CoursesCounterFinder $finder)
    {
        $this->finder = $finder;
    }

    public function __invoke(): Response
    {
        $response = $this->finder->__invoke();

        return new JsonResponse(
            [
                'total' => $response->total(),
            ]
        );
    }
}