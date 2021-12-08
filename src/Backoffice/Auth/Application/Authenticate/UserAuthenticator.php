<?php

namespace LuisCusihuaman\Backoffice\Auth\Application\Authenticate;

use LuisCusihuaman\Backoffice\Auth\Domain\AuthPassword;
use LuisCusihuaman\Backoffice\Auth\Domain\AuthRepository;
use LuisCusihuaman\Backoffice\Auth\Domain\AuthUser;
use LuisCusihuaman\Backoffice\Auth\Domain\AuthUsername;
use LuisCusihuaman\Backoffice\Auth\Domain\InvalidAuthCredentials;
use LuisCusihuaman\Backoffice\Auth\Domain\InvalidAuthUsername;

final class UserAuthenticator
{
    private $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function authenticate(AuthUsername $username, AuthPassword $password): void
    {
        $auth = $this->repository->search($username);

        $this->ensureUserExist($auth, $username);
        $this->ensureCredentialsAreValid($auth, $password);
    }

    private function ensureUserExist(?AuthUser $auth, AuthUsername $username): void
    {
        if (null === $auth) {
            throw new InvalidAuthUsername($username);
        }
    }

    private function ensureCredentialsAreValid(AuthUser $auth, AuthPassword $password): void
    {
        if (!$auth->passwordMatches($password)) {
            throw new InvalidAuthCredentials($auth->username());
        }
    }
}
