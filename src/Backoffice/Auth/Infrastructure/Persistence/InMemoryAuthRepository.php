<?php

namespace LuisCusihuaman\Backoffice\Auth\Infrastructure\Persistence;

use LuisCusihuaman\Backoffice\Auth\Domain\AuthPassword;
use LuisCusihuaman\Backoffice\Auth\Domain\AuthRepository;
use LuisCusihuaman\Backoffice\Auth\Domain\AuthUser;
use LuisCusihuaman\Backoffice\Auth\Domain\AuthUsername;
use function Lambdish\Phunctional\get;

final class InMemoryAuthRepository implements AuthRepository
{
    private const USERS = [
        'luiscusihuaman' => 'password',
    ];

    public function search(AuthUsername $username): ?AuthUser
    {
        $password = get($username->value(), self::USERS);
        return null === $password ? null :
            new AuthUser($username, new AuthPassword($password));
    }
}
