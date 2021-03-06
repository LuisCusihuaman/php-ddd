<?php

namespace LuisCusihuaman\Backoffice\Auth\Domain;

use RuntimeException;

final class InvalidAuthCredentials extends RuntimeException
{
    public function __construct(AuthUsername $username)
    {
        parent::__construct(sprintf('The credentials for <%s> are invalid', $username->value()));
    }
}
