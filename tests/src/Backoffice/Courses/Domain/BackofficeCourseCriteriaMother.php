<?php

namespace LuisCusihuaman\Tests\Backoffice\Courses\Domain;

use LuisCusihuaman\Shared\Domain\Criteria;
use LuisCusihuaman\Tests\Shared\Domain\Criteria\CriteriaMother;
use LuisCusihuaman\Tests\Shared\Domain\Criteria\FilterMother;
use LuisCusihuaman\Tests\Shared\Domain\Criteria\FiltersMother;

final class BackofficeCourseCriteriaMother
{
    public static function nameContains(string $text): Criteria
    {
        return CriteriaMother::create(
            FiltersMother::createOne(
                FilterMother::fromValues(
                    [
                        'field' => 'name',
                        'operator' => 'CONTAINS',
                        'value' => $text,
                    ]
                )
            )
        );
    }
}
