<?php

namespace LuisCusihuaman\Shared\Infrastructure\Persistence\Elasticsearch;

use Elasticsearch\Common\Exceptions\Missing404Exception;
use LuisCusihuaman\Shared\Domain\Criteria;
use LuisCusihuaman\Shared\Infrastructure\Elasticsearch\ElasticsearchClient;
use function Lambdish\Phunctional\get_in;
use function Lambdish\Phunctional\map;

abstract class ElasticsearchRepository
{
    private $client;

    public function __construct(ElasticsearchClient $client)
    {
        $this->client = $client;
    }

    abstract protected function aggregateName(): string;

    protected function persist(string $id, array $plainBody): void
    {
        $this->client->persist($this->aggregateName(), $id, $plainBody);
    }

    protected function searchAllInElastic(): array
    {
        return $this->searchRawElasticsearchQuery([]);
    }

    protected function searchRawElasticsearchQuery(array $params): array
    {
        try {
            $result = $this->client->client()->search(array_merge(['index' => $this->indexName()], $params));

            $hits = get_in(['hits', 'hits'], $result, []);

            return map(static fn(array $elasticValues): array => $elasticValues['_source'], $hits);
        } catch (Missing404Exception $unused) {
            return [];
        }
    }

    protected function indexName(): string
    {
        return sprintf('%s_%s', $this->client->indexPrefix(), $this->aggregateName());
    }

    public function searchByCriteria(Criteria $criteria): array
    {
        $converter = new ElasticsearchCriteriaConverter();

        $query = $converter->convert($criteria);

        return $this->searchRawElasticsearchQuery($query);
    }
}
