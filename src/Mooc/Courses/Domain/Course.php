<?php


namespace LuisCusihuaman\Mooc\Courses\Domain;


class Course
{
    private CourseId $id;
    private string $name;
    private string $duration;

    /**
     * Course constructor.
     * @param CourseId $id
     * @param string $name
     * @param string $duration
     */
    public function __construct(CourseId $id, string $name, string $duration)
    {

        $this->id = $id;
        $this->name = $name;
        $this->duration = $duration;
    }

    public function id(): CourseId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function duration(): string
    {
        return $this->duration;
    }
}