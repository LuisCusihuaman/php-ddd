<?php


namespace LuisCusihuaman\Mooc\Courses\Application\Create;


use LuisCusihuaman\Mooc\Courses\Domain\Course;
use LuisCusihuaman\Mooc\Courses\Domain\CourseId;
use LuisCusihuaman\Mooc\Courses\Domain\CourseRepository;

class CourseCreator
{

    private CourseRepository $repository;

    public function __construct(CourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateCourseRequest $request)
    {
        $id = new CourseId($request->id());
        $course = new Course($id, $request->name(), $request->duration());
        $this->repository->save($course);
    }
}