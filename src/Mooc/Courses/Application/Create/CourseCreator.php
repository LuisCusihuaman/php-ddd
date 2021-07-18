<?php


namespace LuisCusihuaman\Mooc\Courses\Application\Create;


use LuisCusihuaman\Mooc\Courses\Domain\Course;
use LuisCusihuaman\Mooc\Courses\Domain\CourseDuration;
use LuisCusihuaman\Mooc\Courses\Domain\CourseId;
use LuisCusihuaman\Mooc\Courses\Domain\CourseName;
use LuisCusihuaman\Mooc\Courses\Domain\CourseRepository;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEventPublisher;

class CourseCreator
{

    private CourseRepository $repository;
    private $publisher;

    public function __construct(CourseRepository $repository, DomainEventPublisher $publisher)
    {
        $this->repository = $repository;
        $this->publisher = $publisher;
    }

    public function __invoke(CreateCourseRequest $request)
    {
        $id = new CourseId($request->id());
        $name = new CourseName($request->name());
        $duration = new CourseDuration($request->duration());

        $course = Course::create($id, $name, $duration);

        $this->repository->save($course);
        $this->publisher->publish(...$course->pullDomainEvents());
    }
}