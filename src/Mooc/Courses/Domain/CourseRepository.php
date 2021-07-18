<?php


namespace LuisCusihuaman\Mooc\Courses\Domain;


use LuisCusihuaman\Mooc\Shared\Domain\Course\CourseId;

interface CourseRepository
{

    public function save(Course $course): void;

    public function search(CourseId $id): ?Course;
}