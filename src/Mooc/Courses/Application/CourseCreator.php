<?php


namespace LuisCusihuaman\Mooc\Courses\Application;


use LuisCusihuaman\Mooc\Courses\Domain\Course;
use LuisCusihuaman\Mooc\Courses\Domain\CourseRepository;

class CourseCreator
{

    private CourseRepository $repository;

    public function __construct(CourseRepository $repository)
    {

        $this->repository = $repository;
    }

    public function __invoke(string $id, string $name, string $duration)
    {
        $course = new Course($id, $name, $duration);
        $this->repository->save($course);
    }
}