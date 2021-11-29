<?php

namespace LuisCusihuaman\Backoffice\Courses\Domain;


interface BackofficeCourseRepository
{

    public function save(BackofficeCourse $course): void;
}
