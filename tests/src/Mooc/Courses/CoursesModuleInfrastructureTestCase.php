<?php


namespace LuisCusihuaman\Tests\Mooc\Courses;


use LuisCusihuaman\Mooc\Courses\Domain\CourseRepository;
use LuisCusihuaman\Tests\Mooc\Shared\Infrastructure\PhpUnit\MoocContextInfrastructureTestCase;

class CoursesModuleInfrastructureTestCase extends MoocContextInfrastructureTestCase
{
    protected function repository(): CourseRepository
    {
        return $this->service(CourseRepository::class);
    }
}