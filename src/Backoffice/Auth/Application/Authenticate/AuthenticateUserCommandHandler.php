<?php

namespace LuisCusihuaman\Backoffice\Auth\Application\Authenticate;

use LuisCusihuaman\Backoffice\Auth\Domain\AuthPassword;
use LuisCusihuaman\Backoffice\Auth\Domain\AuthUsername;
use LuisCusihuaman\Shared\Domain\Bus\Command\CommandHandler;

final class AuthenticateUserCommandHandler implements CommandHandler
{
    private $authenticator;

    public function __construct(UserAuthenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function __invoke(AuthenticateUserCommand $command)
    {
        $username = new AuthUsername($command->username());
        $password = new AuthPassword($command->password());

        $this->authenticator->authenticate($username, $password);
    }
}
