<?php


namespace LuisCusihuaman\Mooc\CoursesCounter\Application\Find;


final class CoursesCounterResponse
{
    private int $total;

    public function __construct(int $total)
    {
        $this->total = $total;
    }

    public function total(): int
    {
        return $this->total;
    }
}
