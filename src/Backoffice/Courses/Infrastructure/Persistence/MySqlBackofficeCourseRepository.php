<?php

namespace LuisCusihuaman\Backoffice\Courses\Infrastructure\Persistence;

use LuisCusihuaman\Backoffice\Courses\Domain\BackofficeCourse;
use LuisCusihuaman\Backoffice\Courses\Domain\BackofficeCourseRepository;
use LuisCusihuaman\Shared\Domain\Criteria\Criteria;
use LuisCusihuaman\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
use LuisCusihuaman\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class MySqlBackofficeCourseRepository extends DoctrineRepository implements BackofficeCourseRepository
{

    public function save(BackofficeCourse $course): void
    {
        $this->persist($course);
    }

    public function searchAll(): array
    {
        return $this->repository(BackofficeCourse::class)->findAll();
    }

    public function matching(Criteria $criteria): array
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
        $repo = $this->repository(BackofficeCourse::class);
        return $repo->matching($doctrineCriteria)->toArray();
    }
}
