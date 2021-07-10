<?php

declare(strict_types=1);

namespace LuisCusihuaman\Tests\Shared\Domain;

use Faker\Factory;
use Faker\Generator;

final class MotherCreator
{
    private static $faker;

    public static function random(): Generator
    {
        return self::$faker = self::$faker ?: Factory::create();
    }
}
