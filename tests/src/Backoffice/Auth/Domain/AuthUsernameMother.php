<?php

namespace LuisCusihuaman\Tests\Backoffice\Auth\Domain;

use LuisCusihuaman\Backoffice\Auth\Domain\AuthUsername;
use LuisCusihuaman\Tests\Shared\Domain\WordMother;

final class AuthUsernameMother
{
    public static function create(string $value): AuthUsername
    {
        return new AuthUsername($value);
    }

    public static function random(): AuthUsername
    {
        return self::create(WordMother::random());
    }
}
