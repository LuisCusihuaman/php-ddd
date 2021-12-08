<?php

namespace LuisCusihuaman\Shared\Domain\Criteria;

use LuisCusihuaman\Shared\Domain\Collection;
use function Lambdish\Phunctional\reduce;

final class Filters extends Collection
{
    public static function fromValues(array $values): self
    {
        $filterFromValues = array_map(static fn($values) => Filter::fromValues($values), $values);
        return new self($filterFromValues);
    }

    public function filters(): array
    {
        return $this->items();
    }

    public function serialize(): string
    {
        return reduce(
            static function (string $accumulate, Filter $filter) {
                return sprintf('%s^%s', $accumulate, $filter->serialize());
            },
            $this->items(),
            ''
        );
    }

    protected function type(): string
    {
        return Filter::class;
    }
}
