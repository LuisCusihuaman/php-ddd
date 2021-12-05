<?php

namespace LuisCusihuaman\Shared\Domain\Criteria;

use LuisCusihuaman\Shared\Domain\Collection;

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

    protected function type(): string
    {
        return Filter::class;
    }
}
