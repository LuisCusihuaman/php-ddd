<?php

namespace LuisCusihuaman\Apps\Backoffice\Backend\Controller\Courses;

use LuisCusihuaman\Backoffice\Courses\Application\BackofficeCourseResponse;
use LuisCusihuaman\Backoffice\Courses\Application\BackofficeCoursesResponse;
use LuisCusihuaman\Backoffice\Courses\Application\SearchByCriteria\SearchBackofficeCoursesByCriteriaQuery;
use LuisCusihuaman\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use function Lambdish\Phunctional\map;

final class CoursesGetController
{
    private $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        /** @var BackofficeCoursesResponse $response */
        $response = $this->queryBus->ask(
            new SearchBackofficeCoursesByCriteriaQuery(
                $request->query->get('filters', []),
                $request->query->get('order_by'),
                $request->query->get('order'),
                $request->query->get('limit'),
                $request->query->get('offset')
            )
        );

        return new JsonResponse(
            map($this->toArray(), $response->courses()),
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    private function toArray(): callable
    {
        return static function (BackofficeCourseResponse $course) {
            return [
                'id' => $course->id(),
                'name' => $course->name(),
                'duration' => $course->duration(),
            ];
        };
    }
}
