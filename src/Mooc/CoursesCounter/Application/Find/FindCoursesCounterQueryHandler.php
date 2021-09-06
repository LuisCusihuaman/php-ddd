<?php

namespace LuisCusihuaman\Mooc\CoursesCounter\Application\Find;

use LuisCusihuaman\Shared\Domain\Bus\Query\QueryHandler;

final class FindCoursesCounterQueryHandler implements QueryHandler
{
    private $finder;

    public function __construct(CoursesCounterFinder $finder)
    {
        $this->finder = $finder;
    }

    public function __invoke(FindCoursesCounterQuery $query): CoursesCounterResponse
    {
        return $this->finder->__invoke();
    }
}