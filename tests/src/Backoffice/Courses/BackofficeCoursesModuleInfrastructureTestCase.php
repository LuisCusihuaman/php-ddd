<?php

namespace LuisCusihuaman\Tests\Backoffice\Courses;

use LuisCusihuaman\Backoffice\Courses\Domain\BackofficeCourseRepository;
use LuisCusihuaman\Tests\Mooc\Shared\Infrastructure\PhpUnit\MoocContextInfrastructureTestCase;

abstract class BackofficeCoursesModuleInfrastructureTestCase extends MoocContextInfrastructureTestCase
{
    protected function repository(): BackofficeCourseRepository
    {
        return $this->service(BackofficeCourseRepository::class);
    }
}
