<?php


namespace LuisCusihuaman\Tests\Mooc\Courses\Application\Create;


use LuisCusihuaman\Mooc\Courses\Application\Create\CourseCreator;
use LuisCusihuaman\Mooc\Courses\Application\Create\CreateCourseCommandHandler;
use LuisCusihuaman\Tests\Mooc\Courses\CoursesModuleUnitTestCase;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseCreatedDomainEventMother;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseMother;

final class CourseCreateCommandHandlerTest extends CoursesModuleUnitTestCase
{
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new CreateCourseCommandHandler(new CourseCreator($this->repository(), $this->eventBus()));;
    }

    /** @test */
    public function it_should_create_a_valid_course(): void
    {
        $command = CreateCourseCommandMother::random();
        $course = CourseMother::fromRequest($command);
        $domainEvent = CourseCreatedDomainEventMother::fromCourse($course);

        $this->shouldSave($course);
        $this->shouldPublishDomainEvent($domainEvent);

        $this->dispatch($command, $this->handler);
    }
}
