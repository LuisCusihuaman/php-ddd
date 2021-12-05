<?php

namespace LuisCusihuaman\Tests\Shared\Domain\Criteria;

use LuisCusihuaman\Shared\Domain\Criteria\Filter;
use LuisCusihuaman\Shared\Domain\Criteria\FilterField;
use LuisCusihuaman\Shared\Domain\Criteria\FilterOperator;
use LuisCusihuaman\Shared\Domain\Criteria\FilterValue;

final class FilterMother
{
    public static function create(FilterField $field, FilterOperator $operator, FilterValue $value): Filter
    {
        return new Filter($field, $operator, $value);
    }

    public static function fromValues($values): Filter
    {
        return Filter::fromValues($values);
    }

    public static function random(): Filter
    {
        return self::create(FilterFieldMother::random(), FilterOperatorMother::random(), FilterValueMother::random());
    }
}
