<?php

namespace LuisCusihuaman\Tests\Backoffice\Auth\Domain;

use LuisCusihuaman\Backoffice\Auth\Domain\AuthPassword;
use LuisCusihuaman\Tests\Shared\Domain\UuidMother;

final class AuthPasswordMother
{
    public static function create(string $value): AuthPassword
    {
        return new AuthPassword($value);
    }

    public static function random(): AuthPassword
    {
        return self::create(UuidMother::random());
    }
}
