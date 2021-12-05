<?php

namespace LuisCusihuaman\Backoffice\Courses\Application\SearchByCriteria;

use LuisCusihuaman\Backoffice\Courses\Application\BackofficeCoursesResponse;
use LuisCusihuaman\Shared\Domain\Bus\Query\QueryHandler;
use LuisCusihuaman\Shared\Domain\Criteria\Filters;
use LuisCusihuaman\Shared\Domain\Criteria\Order;

class SearchBackofficeCoursesByCriteriaQueryHandler implements QueryHandler
{
    private $searcher;

    public function __construct(BackofficeCoursesByCriteriaSearcher $searcher)
    {
        $this->searcher = $searcher;
    }

    public function __invoke(SearchBackofficeCoursesByCriteriaQuery $query): BackofficeCoursesResponse
    {
        $filters = Filters::fromValues($query->filters());
        $order = Order::fromValues($query->orderBy(), $query->order());

        return $this->searcher->search(
            $filters, $order, $query->limit(), $query->offset());
    }

}
