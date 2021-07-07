<?php


namespace LuisCusihuaman\Mooc\Courses\Domain;


class Course
{
    private string $id;
    private string $name;
    private string $duration;

    /**
     * Course constructor.
     * @param string $id
     * @param string $name
     * @param string $duration
     */
    public function __construct(string $id, string $name, string $duration)
    {

        $this->id = $id;
        $this->name = $name;
        $this->duration = $duration;
    }

    /**
     * @return string
     */
    public function Id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function Name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function Duration(): string
    {
        return $this->duration;
    }
}