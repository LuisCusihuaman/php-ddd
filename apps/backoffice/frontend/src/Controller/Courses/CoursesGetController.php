<?php

namespace LuisCusihuaman\Apps\Backoffice\Frontend\Controller\Courses;

use LuisCusihuaman\Shared\Infrastructure\Symfony\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CoursesGetController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return $this->render(
            'pages/courses.html.twig',
            [
                'title' => 'Courses',
                'description' => 'Backoffice',
                'courses_counter' => 10,
            ]
        );
    }
}
