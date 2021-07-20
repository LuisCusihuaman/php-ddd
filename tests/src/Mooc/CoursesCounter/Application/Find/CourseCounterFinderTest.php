<?php


namespace LuisCusihuaman\Tests\Mooc\CoursesCounter\Application\Find;


use LuisCusihuaman\Mooc\CoursesCounter\Application\Find\CoursesCounterFinder;
use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounterNotExist;
use LuisCusihuaman\Tests\Mooc\CoursesCounter\CoursesCounterModuleUnitTestCase;
use LuisCusihuaman\Tests\Mooc\CoursesCounter\Domain\CoursesCounterMother;

class CourseCounterFinderTest extends CoursesCounterModuleUnitTestCase
{
    private CoursesCounterFinder $finder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->finder = new CoursesCounterFinder($this->repository());
    }

    /** @test */
    public function it_should_find_an_existing_courses_counter(): void
    {
        $counter = CoursesCounterMother::random();
        $response = CoursesCounterResponseMother::create($counter->total());

        $this->shouldSearch($counter);
        $this->assertEquals($response, $this->finder->__invoke());
    }

    /** @test */
    public function it_should_throw_an_exception_when_courses_counter_does_not_exists(): void
    {
        $this->expectException(CoursesCounterNotExist::class);

        $this->shouldSearch(null);

        $this->finder->__invoke();
    }
}