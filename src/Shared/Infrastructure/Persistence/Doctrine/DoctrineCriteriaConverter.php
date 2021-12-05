<?php

namespace LuisCusihuaman\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\Common\Collections\Criteria as DoctrineCriteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use LuisCusihuaman\Shared\Domain\Criteria;
use LuisCusihuaman\Shared\Domain\Criteria\Filter;
use LuisCusihuaman\Shared\Domain\Criteria\FilterField;
use LuisCusihuaman\Shared\Domain\Criteria\FilterValue;
use LuisCusihuaman\Shared\Domain\Criteria\OrderBy;

final class DoctrineCriteriaConverter
{
    private $criteriaToDoctrineFields;
    private $criteria;
    private $hydrators;

    public function __construct(Criteria $criteria, array $criteriaToDoctrineFields = [], array $hydrators = [])
    {
        $this->criteria = $criteria;
        $this->criteriaToDoctrineFields = $criteriaToDoctrineFields;
        $this->hydrators = $hydrators;
    }

    public static function convert(Criteria $criteria, array $criteriaToDoctrineFields = [], array $hydrators = []):
    DoctrineCriteria
    {
        $converter = new self($criteria, $criteriaToDoctrineFields, $hydrators);
        return $converter->convertToDoctrineCriteria();
    }

    private function convertToDoctrineCriteria(): DoctrineCriteria
    {
        $expression = $this->buildExpression($this->criteria);
        $orderings = $this->formatOrderBy($this->criteria);
        $offset = $this->criteria->offset();
        $limit = $this->criteria->limit();

        return new DoctrineCriteria($expression, $orderings, $offset, $limit);
    }

    /**
     * Build expression for filtering selection on Doctrine query
     * @param Criteria $criteria
     * @return CompositeExpression|null
     */
    private function buildExpression(Criteria $criteria): ?CompositeExpression
    {
        if (!$criteria->hasFilters()) {
            return null;
        }
        $filters = $criteria->plainFilters();
        $expressions = array_map($this->buildComparison(), $filters);

        return new CompositeExpression(CompositeExpression::TYPE_AND, $expressions);
    }

    private function formatOrderBy(Criteria $criteria): ?array
    {
        if (!$criteria->hasOrder()) {
            return null;
        }

        $orderBy = $this->mapOrderBy($criteria->order()->orderBy());
        $orderType = $criteria->order()->orderType()->value();
        return [$orderBy => $orderType];
    }

    private function buildComparison(): callable
    {
        return function (Filter $filter): Comparison {
            $field = $this->mapFieldValue($filter->field());
            $value = $this->mapHydratorFilterValue($field, $filter->value());

            return new Comparison($field, $filter->operator()->value(), $value);
        };
    }

    // Utility maps

    private function mapOrderBy(OrderBy $field)
    {
        return array_key_exists($field->value(), $this->criteriaToDoctrineFields) ?
            $this->criteriaToDoctrineFields[$field->value()] : $field->value();
    }

    private function mapFieldValue(FilterField $field): string
    {
        return array_key_exists($field->value(), $this->criteriaToDoctrineFields) ?
            $this->criteriaToDoctrineFields[$field->value()] : $field->value();
    }

    private function mapHydratorFilterValue(string $field, FilterValue $filter): string
    {
        return array_key_exists($field, $this->hydrators) ?
            $this->hydrateValue($field, $filter->value()) : $filter->value();
    }

    private function hydrateValue($field, $value): string
    {
        return $this->hydrators[$field]($value);
    }
}
