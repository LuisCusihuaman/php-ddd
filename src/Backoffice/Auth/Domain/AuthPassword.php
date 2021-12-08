<?php

namespace LuisCusihuaman\Backoffice\Auth\Domain;

use LuisCusihuaman\Shared\Domain\ValueObject\StringValueObject;

final class AuthPassword extends StringValueObject
{
    public function isEquals(AuthPassword $other): bool
    {
        return $this->value() === $other->value();
    }
}
