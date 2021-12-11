<?php

namespace LuisCusihuaman\Shared\Domain;

use DomainException;

abstract class DomainError extends DomainException
{
    public function __construct()
    {
        parent::__construct($this->errorMessage());
    }


    /** Error that the controller will return when a domain error is thrown
     * e.g: 'video_not_found', 'course_not_exist'
     * @return string
     */
    abstract public function errorCode(): string;

    abstract protected function errorMessage(): string;
}
