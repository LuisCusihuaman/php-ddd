<?php

namespace LuisCusihuaman\Backoffice\Auth\Application\Authenticate;

use LuisCusihuaman\Shared\Domain\Bus\Command\Command;

final class AuthenticateUserCommand implements Command
{
    private $username;
    private $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function password(): string
    {
        return $this->password;
    }
}
