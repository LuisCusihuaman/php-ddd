<?php


namespace LuisCusihuaman\Tests\Shared\Domain;


use LuisCusihuaman\Tests\Shared\Infrastructure\Mockery\BusinessMatcherIsSimilar;
use LuisCusihuaman\Tests\Shared\Infrastructure\PhpUnit\Constraint\BusinessConstraintIsSimilar;

final class TestUtils
{
    public static function isSimilar($expected, $actual): bool
    {
        $constraint = new BusinessConstraintIsSimilar($expected);

        return $constraint->evaluate($actual, '', true);
    }

    public static function similarTo($value, $delta = 0.0): BusinessMatcherIsSimilar
    {
        return new BusinessMatcherIsSimilar($value, $delta);
    }
}