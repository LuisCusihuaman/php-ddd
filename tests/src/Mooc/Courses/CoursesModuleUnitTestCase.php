<?php


namespace LuisCusihuaman\Tests\Mooc\Courses;


use LuisCusihuaman\Mooc\Courses\Domain\Course;
use LuisCusihuaman\Mooc\Courses\Domain\CourseRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CoursesModuleUnitTestCase extends TestCase
{
    private $repository;

    protected function shouldSave(Course $course): void
    {
        $this->repository()->method('save')->with($course);
    }

    /** @return CourseRepository|MockObject */
    protected function repository(): MockObject
    {
        return $this->repository = $this->repository ?: $this->createMock(CourseRepository::class);
    }
}