<?php

namespace LuisCusihuaman\Tests\Backoffice\Courses;

use Doctrine\ORM\EntityManager;
use LuisCusihuaman\Backoffice\Courses\Infrastructure\Persistence\MySqlBackofficeCourseRepository;
use LuisCusihuaman\Tests\Mooc\Shared\Infrastructure\PhpUnit\MoocContextInfrastructureTestCase;

abstract class BackofficeCoursesModuleInfrastructureTestCase extends MoocContextInfrastructureTestCase
{
    protected function repository(): MySqlBackofficeCourseRepository
    {
        return new MySqlBackofficeCourseRepository($this->service(EntityManager::class));

    }
}
