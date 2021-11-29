<?php

namespace LuisCusihuaman\Backoffice\Courses\Application\SearchAll;

use LuisCusihuaman\Backoffice\Courses\Application\BackofficeCourseResponse;
use LuisCusihuaman\Backoffice\Courses\Application\BackofficeCoursesResponse;
use LuisCusihuaman\Backoffice\Courses\Domain\BackofficeCourse;
use LuisCusihuaman\Backoffice\Courses\Domain\BackofficeCourseRepository;
use function Lambdish\Phunctional\map;

final class AllBackofficeCoursesSearcher
{
    private $repository;

    public function __construct(BackofficeCourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function searchAll(): BackofficeCoursesResponse
    {
        $backofficeCoursesResponseQueryResults = map($this->toResponse(), $this->repository->searchAll());
        return new BackofficeCoursesResponse(...$backofficeCoursesResponseQueryResults);
    }

    private function toResponse(): callable
    {
        return static function (BackofficeCourse $course) {
            return new BackofficeCourseResponse($course->id(), $course->name(), $course->duration());
        };
    }
}
