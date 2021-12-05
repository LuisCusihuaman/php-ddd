<?php

namespace LuisCusihuaman\Shared\Domain\Criteria;

use InvalidArgumentException;
use LuisCusihuaman\Shared\Domain\ValueObject\Enum;

/**
 * @method static FilterOperator gt()
 * @method static FilterOperator lt()
 * @method static FilterOperator like()
 */
final class FilterOperator extends Enum
{
    public const EQUAL = '=';
    public const GT = '>';
    public const LT = '<';
    public const CONTAINS = 'CONTAINS';

    public static function equal(): self
    {
        return new self('=');
    }

    protected function throwExceptionForInvalidValue($value): void
    {
        throw new InvalidArgumentException(sprintf('The filter <%s> is invalid', $value));
    }
}
