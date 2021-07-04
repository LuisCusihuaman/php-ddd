<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Infrastructure;

final class RandomNumberGeneratorTest
{
    public function generate(): int
    {
        return random_int(1, 5);
    }
}
