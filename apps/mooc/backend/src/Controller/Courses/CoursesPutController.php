<?php


namespace LuisCusihuaman\Apps\Mooc\Backend\Controller\Courses;


use LuisCusihuaman\Mooc\Courses\Application\CourseCreator;
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
        $name = $request->get('name');
        $duration = $request->get('duration');

        $creator = $this->creator;
        $creator($id, $name, $duration);

        return new Response("", Response::HTTP_CREATED);
    }
}