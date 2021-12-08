<?php

namespace LuisCusihuaman\Tests\Backoffice\Auth\Application\Authenticate;

use LuisCusihuaman\Backoffice\Auth\Application\Authenticate\AuthenticateUserCommandHandler;
use LuisCusihuaman\Backoffice\Auth\Application\Authenticate\UserAuthenticator;
use LuisCusihuaman\Backoffice\Auth\Domain\InvalidAuthCredentials;
use LuisCusihuaman\Backoffice\Auth\Domain\InvalidAuthUsername;
use LuisCusihuaman\Tests\Backoffice\Auth\AuthModuleUnitTestCase;
use LuisCusihuaman\Tests\Backoffice\Auth\Domain\AuthUserMother;
use LuisCusihuaman\Tests\Backoffice\Auth\Domain\AuthUsernameMother;

final class AuthenticateUserCommandHandlerTest extends AuthModuleUnitTestCase
{
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $useCaseService = new UserAuthenticator($this->repository());
        $this->handler = new AuthenticateUserCommandHandler($useCaseService);
    }

    /** @test */
    public function it_should_authenticate_a_valid_user(): void
    {
        $command = AuthenticateUserCommandMother::random();
        $authUser = AuthUserMother::fromCommand($command);

        $this->shouldSearch($authUser->username(), $authUser);

        $this->dispatch($command, $this->handler);
    }

    /** @test */
    public function it_should_throw_an_exception_when_the_user_does_not_exist(): void
    {
        $this->expectException(InvalidAuthUsername::class);

        $command = AuthenticateUserCommandMother::random();
        $username = AuthUsernameMother::create($command->username());

        $this->shouldSearch($username);

        $this->dispatch($command, $this->handler);
    }

    /** @test */
    public function it_should_throw_an_exception_when_the_password_does_not_math(): void
    {
        $this->expectException(InvalidAuthCredentials::class);

        $command = AuthenticateUserCommandMother::random();
        $authUser = AuthUserMother::withUsername(AuthUsernameMother::create($command->username()));

        $this->shouldSearch($authUser->username(), $authUser);

        $this->dispatch($command, $this->handler);
    }
}
