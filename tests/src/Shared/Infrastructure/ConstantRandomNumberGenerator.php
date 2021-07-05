<?php

declare(strict_types = 1);

namespace LuisCusihuaman\Tests\Shared\Infrastructure;

use LuisCusihuaman\Shared\Domain\RandomNumberGenerator;

final class ConstantRandomNumberGenerator implements RandomNumberGenerator
{
    public function generate(): int
    {
        return 1;
    }
}
