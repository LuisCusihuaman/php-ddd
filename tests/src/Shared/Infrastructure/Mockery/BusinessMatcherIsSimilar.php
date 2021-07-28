<?php


namespace LuisCusihuaman\Tests\Shared\Infrastructure\Mockery;


use LuisCusihuaman\Tests\Shared\Infrastructure\PhpUnit\Constraint\BusinessConstraintIsSimilar;
use Mockery\Matcher\MatcherAbstract;

final class BusinessMatcherIsSimilar extends MatcherAbstract
{
    private $constraint;

    public function __construct($value, $delta = 0.0)
    {
        parent::__construct($value);

        $this->constraint = new BusinessConstraintIsSimilar($value, $delta);
    }

    public function match(&$actual): bool
    {
        return $this->constraint->evaluate($actual, '', true);
    }

    public function __toString(): string
    {
        return 'Is similar';
    }
}