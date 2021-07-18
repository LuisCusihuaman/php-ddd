<?php


namespace LuisCusihuaman\Tests\Mooc\Courses;


use LuisCusihuaman\Mooc\Courses\Domain\Course;
use LuisCusihuaman\Mooc\Courses\Domain\CourseRepository;
use LuisCusihuaman\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CoursesModuleUnitTestCase extends UnitTestCase
{
    private $repository;

    protected function shouldSave(Course $course): void
    {
        // withAnyParameters insted of with(course) because we can't compare the body
        $this->repository()->method('save')->withAnyParameters();
    }

    /** @return CourseRepository|MockObject */
    protected function repository(): MockObject
    {
        return $this->repository = $this->repository ?: $this->createMock(CourseRepository::class);
    }
}