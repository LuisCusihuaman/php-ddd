<?php


namespace LuisCusihuaman\Apps\Mooc\Backend\Controller\Courses;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CoursesPutController
{
    public function __invoke(string $id, Request $request): Response
    {
        return new Response("", 201);
    }
}