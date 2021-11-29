<?php

namespace LuisCusihuaman\Backoffice\Courses\Application\Create;

use LuisCusihuaman\Backoffice\Courses\Domain\BackofficeCourse;
use LuisCusihuaman\Backoffice\Courses\Domain\BackofficeCourseRepository;

class BackofficeCourseCreator
{
    private $repository;

    public function __construct(BackofficeCourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(string $id, string $name, string $duration)
    {
        $this->repository->save(new BackofficeCourse($id, $name, $duration));
    }
}
