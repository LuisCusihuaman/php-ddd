<?php


namespace LuisCusihuaman\Tests\Mooc\Courses\Application\Create;


use LuisCusihuaman\Mooc\Courses\Application\Create\CourseCreator;
use LuisCusihuaman\Tests\Mooc\Courses\CoursesModuleUnitTestCase;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseCreatedDomainEventMother;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseMother;

final class CourseCreatorTest extends CoursesModuleUnitTestCase
{
    private CourseCreator $creator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->creator = new CourseCreator($this->repository(), $this->domainEventPublisher());
    }

    /** @test */
    public function it_should_create_a_valid_course(): void
    {
        $request = CreateCourseRequestMother::random();
        $course = CourseMother::fromRequest($request);
        $domainEvent = CourseCreatedDomainEventMother::fromCourse($course);

        $this->shouldSave($course);
        $this->shouldPublishDomainEvent($domainEvent);

        $this->creator->__invoke($request);
    }
}
