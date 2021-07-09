<?php


namespace LuisCusihuaman\Mooc\Courses\Domain;


class Course
{
    private CourseId $id;
    private CourseName $name;
    private CourseDuration $duration;

    public function __construct(CourseId $id, CourseName $name, CourseDuration $duration)
    {

        $this->id = $id;
        $this->name = $name;
        $this->duration = $duration;
    }

    public function id(): CourseId
    {
        return $this->id;
    }

    public function name(): CourseName
    {
        return $this->name;
    }

    public function duration(): CourseDuration
    {
        return $this->duration;
    }
}