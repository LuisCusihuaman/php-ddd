<?php


namespace LuisCusihuaman\Apps\Mooc\Backend\Controller\Courses;


use LuisCusihuaman\Mooc\Courses\Application\Create\CourseCreator;
use LuisCusihuaman\Mooc\Courses\Application\Create\CreateCourseRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CoursesPutController
{
    private CourseCreator $creator;

    public function __construct(CourseCreator $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke(string $id, Request $request): Response
    {
        $this->creator->__invoke(
            new CreateCourseRequest(
                $id,
                $request->request->get('name'),
                $request->request->get('duration')
            )
        );

        return new Response("", Response::HTTP_CREATED);
    }
}