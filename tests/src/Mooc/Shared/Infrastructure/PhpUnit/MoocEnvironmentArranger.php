<?php


namespace LuisCusihuaman\Tests\Mooc\Shared\Infrastructure\PhpUnit;


use Doctrine\ORM\EntityManager;
use LuisCusihuaman\Tests\Shared\Infrastructure\Arranger\EnvironmentArranger;
use LuisCusihuaman\Tests\Shared\Infrastructure\Doctrine\DatabaseCleaner;
use function Lambdish\Phunctional\apply;

final class MoocEnvironmentArranger implements EnvironmentArranger
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function arrange(): void
    {
        apply(new DatabaseCleaner(), [$this->entityManager]);
    }

    public function close(): void
    {
    }
}