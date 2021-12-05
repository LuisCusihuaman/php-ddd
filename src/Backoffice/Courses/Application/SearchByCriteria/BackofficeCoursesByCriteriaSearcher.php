<?php

namespace LuisCusihuaman\Backoffice\Courses\Application\SearchByCriteria;

use LuisCusihuaman\Backoffice\Courses\Application\BackofficeCourseResponse;
use LuisCusihuaman\Backoffice\Courses\Application\BackofficeCoursesResponse;
use LuisCusihuaman\Backoffice\Courses\Domain\BackofficeCourse;
use LuisCusihuaman\Backoffice\Courses\Domain\BackofficeCourseRepository;
use LuisCusihuaman\Shared\Domain\Criteria;
use LuisCusihuaman\Shared\Domain\Criteria\Filters;
use LuisCusihuaman\Shared\Domain\Criteria\Order;
use function Lambdish\Phunctional\map;

class BackofficeCoursesByCriteriaSearcher
{
    private $repository;

    public function __construct(BackofficeCourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function search(Filters $filters, Order $order, ?int $limit, ?int $offset): BackofficeCoursesResponse
    {
        $criteria = new Criteria($filters, $order, $offset, $limit);
        $coursesResponse = map($this->toResponse(), $this->repository->matching($criteria));
        return new BackofficeCoursesResponse(...$coursesResponse);
    }

    public function toResponse(): callable
    {
        return static function (BackofficeCourse $course) {
            return new BackofficeCourseResponse($course->id(), $course->name(), $course->duration());
        };
    }


}
