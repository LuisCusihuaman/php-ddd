<?php


namespace CodelyTv\Shared\Domain;


interface RandomNumberGenerator
{
    public function generate(): int;
}