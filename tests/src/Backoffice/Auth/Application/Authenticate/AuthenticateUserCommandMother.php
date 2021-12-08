<?php

namespace LuisCusihuaman\Tests\Backoffice\Auth\Application\Authenticate;

use LuisCusihuaman\Backoffice\Auth\Application\Authenticate\AuthenticateUserCommand;
use LuisCusihuaman\Backoffice\Auth\Domain\AuthPassword;
use LuisCusihuaman\Backoffice\Auth\Domain\AuthUsername;
use LuisCusihuaman\Tests\Backoffice\Auth\Domain\AuthPasswordMother;
use LuisCusihuaman\Tests\Backoffice\Auth\Domain\AuthUsernameMother;

final class AuthenticateUserCommandMother
{
    public static function create(AuthUsername $username, AuthPassword $password): AuthenticateUserCommand
    {
        return new AuthenticateUserCommand($username->value(), $password->value());
    }

    public static function random(): AuthenticateUserCommand
    {
        return self::create(AuthUsernameMother::random(), AuthPasswordMother::random());
    }
}
