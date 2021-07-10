<?php


namespace LuisCusihuaman\Tests\Mooc\Courses\Infrastructure;


use LuisCusihuaman\Mooc\Courses\Domain\CourseId;
use LuisCusihuaman\Mooc\Courses\Infrastructure\FileCourseRepository;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseMother;
use PHPUnit\Framework\TestCase;


final class FileCourseRepositoryTest extends TestCase
{
    /** @test */
    public function it_should_save_a_course(): void
    {
        $repository = new FileCourseRepository();
        $course = CourseMother::random();

        $repository->save($course);
    }

    /** @test */
    public function it_should_return_an_existing_course(): void
    {
        $repository = new FileCourseRepository();
        $course = CourseMother::random();

        $repository->save($course);

        $this->assertEquals($course, $repository->search($course->id()));
    }

    /** @test */
    public function it_should_not_return_a_non_existing_course(): void
    {
        $repository = new FileCourseRepository();

        $this->assertNull($repository->search(new CourseId('65cc2174-30bf-4630-9392-f8084f088cc6')));
    }
}
