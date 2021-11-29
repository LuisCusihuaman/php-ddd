<?php

namespace LuisCusihuaman\Apps\Backoffice\Frontend\Controller\Courses;

use LuisCusihuaman\Mooc\CoursesCounter\Application\Find\CoursesCounterResponse;
use LuisCusihuaman\Mooc\CoursesCounter\Application\Find\FindCoursesCounterQuery;
use LuisCusihuaman\Shared\Domain\ValueObject\Uuid;
use LuisCusihuaman\Shared\Infrastructure\Symfony\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

final class CoursesGetController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $totalCourses = 0;

        try {
            /** @var CoursesCounterResponse $response */
            $response = $this->ask(new FindCoursesCounterQuery());
            $totalCourses = $response->total();
        } catch (HandlerFailedException $ex) {
        }

        return $this->render(
            'pages/courses/courses.html.twig',
            [
                'title' => 'Courses',
                'description' => 'Backoffice',
                'courses_counter' => $totalCourses,
                'new_course_id' => Uuid::random()->value(),
            ]
        );
    }
}
