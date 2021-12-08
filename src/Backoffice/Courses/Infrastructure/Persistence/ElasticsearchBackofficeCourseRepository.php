<?php

namespace LuisCusihuaman\Backoffice\Courses\Infrastructure\Persistence;

use LuisCusihuaman\Backoffice\Courses\Domain\BackofficeCourse;
use LuisCusihuaman\Backoffice\Courses\Domain\BackofficeCourseRepository;
use LuisCusihuaman\Shared\Domain\Criteria\Criteria;
use LuisCusihuaman\Shared\Infrastructure\Persistence\Elasticsearch\ElasticsearchRepository;
use function Lambdish\Phunctional\map;

final class ElasticsearchBackofficeCourseRepository extends ElasticsearchRepository implements BackofficeCourseRepository
{
    protected function aggregateName(): string
    {
        return 'courses';
    }

    public function save(BackofficeCourse $course): void
    {
        $this->persist($course->id(), $course->toPrimitives());
    }

    public function searchAll(): array
    {
        return map($this->toCourse(), $this->searchAllInElastic());
    }

    public function matching(Criteria $criteria): array
    {
        return map($this->toCourse(), $this->searchByCriteria($criteria));
    }

    private function toCourse(): callable
    {
        return static function (array $primitives) {
            return BackofficeCourse::fromPrimitives($primitives);
        };
    }
}
