<?php


namespace LuisCusihuaman\Tests\Mooc\Courses\Application;


use LuisCusihuaman\Mooc\Courses\Application\Create\CourseCreator;
use LuisCusihuaman\Mooc\Courses\Application\Create\CreateCourseRequest;
use LuisCusihuaman\Mooc\Courses\Domain\Course;
use LuisCusihuaman\Mooc\Courses\Domain\CourseId;
use LuisCusihuaman\Mooc\Courses\Domain\CourseRepository;
use PHPUnit\Framework\TestCase;

final class CourseCreatorTest extends TestCase
{
    /** @test */
    public function it_should_create_a_valid_course(): void
    {
        $repository = $this->createMock(CourseRepository::class);
        $creator = new CourseCreator($repository);

        $request = new CreateCourseRequest('decf33ca-81a7-419f-a07a-74f214e928e5', 'some-name', 'some-duration');

        $course = new Course(
            new CourseId($request->id()),
            $request->name(),
            $request->duration()
        );

        $repository->method('save')->with($course);

        $creator->__invoke($request);
    }
}
