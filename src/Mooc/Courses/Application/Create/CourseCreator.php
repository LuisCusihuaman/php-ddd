<?php


namespace LuisCusihuaman\Mooc\Courses\Application\Create;


use LuisCusihuaman\Mooc\Courses\Domain\Course;
use LuisCusihuaman\Mooc\Courses\Domain\CourseDuration;
use LuisCusihuaman\Mooc\Courses\Domain\CourseName;
use LuisCusihuaman\Mooc\Courses\Domain\CourseRepository;
use LuisCusihuaman\Mooc\Shared\Domain\Course\CourseId;
use LuisCusihuaman\Shared\Domain\Bus\Event\EventBus;


class CourseCreator
{

    private CourseRepository $repository;
    private $bus;

    public function __construct(CourseRepository $repository, EventBus $bus)
    {
        $this->repository = $repository;
        $this->bus = $bus;
    }

    public function __invoke(CreateCourseRequest $request)
    {
        $id = new CourseId($request->id());
        $name = new CourseName($request->name());
        $duration = new CourseDuration($request->duration());

        $course = Course::create($id, $name, $duration);

        $this->repository->save($course);
        $this->bus->publish(...$course->pullDomainEvents());
    }
}