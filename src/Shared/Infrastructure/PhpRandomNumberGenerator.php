<?php

declare(strict_types=1);

namespace LuisCusihuaman\Shared\Infrastructure;

use LuisCusihuaman\Shared\Domain\RandomNumberGenerator;

final class PhpRandomNumberGenerator implements RandomNumberGenerator
{
    public function generate(): int
    {
        return random_int(1, 5);
    }
}
