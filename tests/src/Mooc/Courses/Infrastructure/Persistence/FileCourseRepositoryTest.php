<?php


namespace LuisCusihuaman\Tests\Mooc\Courses\Infrastructure\Persistence;

use LuisCusihuaman\Tests\Mooc\Courses\CoursesModuleInfrastructureTestCase;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseIdMother;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseMother;


final class FileCourseRepositoryTest extends CoursesModuleInfrastructureTestCase
{
    /** @test */
    public function it_should_save_a_course(): void
    {
        $course = CourseMother::random();

        $this->repository()->save($course);
    }

    /** @test */
    public function it_should_return_an_existing_course(): void
    {
        $course = CourseMother::random();

        $this->repository()->save($course);

        $this->assertEquals($course, $this->repository()->search($course->id()));
    }

    /** @test */
    public function it_should_not_return_a_non_existing_course(): void
    {
        $this->assertNull($this->repository()->search(CourseIdMother::random()));
    }
}
