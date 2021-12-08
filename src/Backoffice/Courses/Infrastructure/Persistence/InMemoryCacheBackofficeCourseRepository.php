<?php

declare(strict_types=1);

namespace LuisCusihuaman\Backoffice\Courses\Infrastructure\Persistence;

use LuisCusihuaman\Backoffice\Courses\Domain\BackofficeCourse;
use LuisCusihuaman\Backoffice\Courses\Domain\BackofficeCourseRepository;
use LuisCusihuaman\Shared\Domain\Criteria\Criteria;
use function Lambdish\Phunctional\get;

final class InMemoryCacheBackofficeCourseRepository implements BackofficeCourseRepository
{
    private static array $allCoursesCache = [];
    private static array $matchingCache = [];
    private BackofficeCourseRepository $repository;

    public function __construct(BackofficeCourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save(BackofficeCourse $course): void
    {
        $this->repository->save($course);
    }

    public function searchAll(): array
    {
        return empty(self::$allCoursesCache) ? $this->searchAllAndFillCache() : self::$allCoursesCache;
    }

    public function matching(Criteria $criteria): array
    {
        return get($criteria->serialize(), self::$matchingCache) ?: $this->searchMatchingAndFillCache($criteria);
    }

    private function searchAllAndFillCache(): array
    {
        return self::$allCoursesCache = $this->repository->searchAll();
    }

    private function searchMatchingAndFillCache(Criteria $criteria): array
    {
        $criteriaKey = $criteria->serialize();
        return self::$matchingCache[$criteriaKey] = $this->repository->matching($criteria);
    }
}
