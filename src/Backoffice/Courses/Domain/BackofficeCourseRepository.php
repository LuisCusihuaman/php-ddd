<?php

namespace LuisCusihuaman\Backoffice\Courses\Domain;


use LuisCusihuaman\Shared\Domain\Criteria\Criteria;

interface BackofficeCourseRepository
{

    public function save(BackofficeCourse $course): void;

    public function searchAll(): array;

    public function matching(Criteria $criteria): array;
}
