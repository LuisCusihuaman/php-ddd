<?php

namespace LuisCusihuaman\Backoffice\Courses\Domain;


interface BackofficeCourseRepository
{

    public function save(BackofficeCourse $course): void;

    public function searchAll(): array;
}
