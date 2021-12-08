<?php

namespace LuisCusihuaman\Backoffice\Auth\Domain;

interface AuthRepository
{
    public function search(AuthUsername $username): ?AuthUser;
}
