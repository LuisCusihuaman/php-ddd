<?php

namespace LuisCusihuaman\Apps\Backoffice\Frontend\Controller\Courses;

use LuisCusihuaman\Backoffice\Courses\Application\BackofficeCourseResponse;
use LuisCusihuaman\Backoffice\Courses\Application\BackofficeCoursesResponse;
use LuisCusihuaman\Backoffice\Courses\Application\SearchByCriteria\SearchBackofficeCoursesByCriteriaQuery;
use LuisCusihuaman\Shared\Infrastructure\Symfony\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use function Lambdish\Phunctional\map;

final class ApiCoursesGetController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        /** @var BackofficeCoursesResponse $response */
        $response = $this->ask(
            new SearchBackofficeCoursesByCriteriaQuery(
                $request->query->get('filters', []),
                $request->query->get('order_by'),
                $request->query->get('order'),
                $request->query->get('limit'),
                $request->query->get('offset')
            )
        );

        $arrayOfJsonCourses = map($this->toArray(), $response->courses());
        return new JsonResponse($arrayOfJsonCourses);
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
