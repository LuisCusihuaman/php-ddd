<?php

namespace LuisCusihuaman\Shared\Infrastructure\Persistence\Elasticsearch;

use LuisCusihuaman\Shared\Domain\Criteria;
use function Lambdish\Phunctional\reduce;

final class ElasticsearchCriteriaConverter
{
    public function convert(Criteria $criteria): array
    {
        return [
            'body' => array_merge(
                ['from' => $criteria->offset() ?: 0, 'size' => $criteria->limit() ?: 1000],
                $this->formatQuery($criteria),
                $this->formatSort($criteria)
            ),
        ];
    }

    private function formatQuery(Criteria $criteria): array
    {
        if (!$criteria->hasFilters()) {
            return [];
        }
        $queryWithFilters = reduce(new ElasticQueryGenerator(), $criteria->filters(), []);

        return [
            'query' => [
                'bool' => $queryWithFilters
            ],
        ];

    }

    private function formatSort(Criteria $criteria): array
    {
        if (!$criteria->hasOrder()) {
            return [];
        }
        $order = $criteria->order();

        return ['sort' => [$order->orderBy()->value() => ['order' => $order->orderType()->value()]]];

    }
}
