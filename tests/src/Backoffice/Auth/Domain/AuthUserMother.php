<?php

namespace LuisCusihuaman\Tests\Backoffice\Auth\Domain;

use LuisCusihuaman\Backoffice\Auth\Application\Authenticate\AuthenticateUserCommand;
use LuisCusihuaman\Backoffice\Auth\Domain\AuthPassword;
use LuisCusihuaman\Backoffice\Auth\Domain\AuthUser;
use LuisCusihuaman\Backoffice\Auth\Domain\AuthUsername;

final class AuthUserMother
{
    public static function create(AuthUsername $username, AuthPassword $password): AuthUser
    {
        return new AuthUser($username, $password);
    }

    public static function fromCommand(AuthenticateUserCommand $command): AuthUser
    {
        return self::create(
            AuthUsernameMother::create($command->username()),
            AuthPasswordMother::create($command->password())
        );
    }

    public static function withUsername(AuthUsername $username): AuthUser
    {
        return self::create($username, AuthPasswordMother::random());
    }

    public static function random(): AuthUser
    {
        return self::create(AuthUsernameMother::random(), AuthPasswordMother::random());
    }
}
