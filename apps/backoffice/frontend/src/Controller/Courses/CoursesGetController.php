<?php

namespace LuisCusihuaman\Apps\Backoffice\Frontend\Controller\Courses;

use LuisCusihuaman\Mooc\CoursesCounter\Application\Find\CoursesCounterResponse;
use LuisCusihuaman\Mooc\CoursesCounter\Application\Find\FindCoursesCounterQuery;
use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounterNotExist;
use LuisCusihuaman\Shared\Domain\ValueObject\Uuid;
use LuisCusihuaman\Shared\Infrastructure\Symfony\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

final class CoursesGetController extends Controller
{
    public function __invoke(Request $request): Response
    {
        try {
            /** @var CoursesCounterResponse $response */
            $coursesCounterResponse = $this->ask(new FindCoursesCounterQuery());
            $totalCourses = $coursesCounterResponse->total();
        } catch (HandlerFailedException $ex) {
            if ($ex->getPrevious() instanceof CoursesCounterNotExist) {
                $totalCourses = 0;
            }
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
