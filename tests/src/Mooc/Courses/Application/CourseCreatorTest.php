<?php


namespace LuisCusihuaman\Tests\Mooc\Courses\Application;


use LuisCusihuaman\Mooc\Courses\Application\Create\CourseCreator;
use LuisCusihuaman\Tests\Mooc\Courses\Application\Create\CreateCourseRequestMother;
use LuisCusihuaman\Tests\Mooc\Courses\CoursesModuleUnitTestCase;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseMother;

final class CourseCreatorTest extends CoursesModuleUnitTestCase
{
    private CourseCreator $creator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->creator = new CourseCreator($this->repository());
    }

    /** @test */
    public function it_should_create_a_valid_course(): void
    {
        $request = CreateCourseRequestMother::random();

        $course = CourseMother::fromRequest($request);

        $this->shouldSave($course);

        $this->creator->__invoke($request);
    }
}
