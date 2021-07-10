<?php


namespace LuisCusihuaman\Tests\Mooc\Courses;


use LuisCusihuaman\Mooc\Courses\Infrastructure\FileCourseRepository;
use PHPUnit\Framework\TestCase;

class CoursesModuleInfrastructureTestCase extends TestCase
{
    protected function repository(): FileCourseRepository
    {
        return new FileCourseRepository();
    }
}