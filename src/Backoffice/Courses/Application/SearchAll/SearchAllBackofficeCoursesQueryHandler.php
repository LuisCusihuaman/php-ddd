<?php

namespace LuisCusihuaman\Backoffice\Courses\Application\SearchAll;

use LuisCusihuaman\Backoffice\Courses\Application\BackofficeCoursesResponse;
use LuisCusihuaman\Shared\Domain\Bus\Query\QueryHandler;

final class SearchAllBackofficeCoursesQueryHandler implements QueryHandler
{
    private $searcher;

    public function __construct(AllBackofficeCoursesSearcher $searcher)
    {
        $this->searcher = $searcher;
    }

    public function __invoke(SearchAllBackofficeCoursesQuery $query): BackofficeCoursesResponse
    {
        return $this->searcher->searchAll();
    }
}
