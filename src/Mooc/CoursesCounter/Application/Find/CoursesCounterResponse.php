<?php


namespace LuisCusihuaman\Mooc\CoursesCounter\Application\Find;


use LuisCusihuaman\Shared\Domain\Bus\Query\Response;

final class CoursesCounterResponse implements Response
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
