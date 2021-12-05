<?php


namespace LuisCusihuaman\Tests\Mooc\Shared\Infrastructure\PhpUnit;


use Doctrine\ORM\EntityManager;
use LuisCusihuaman\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;

abstract class MoocContextInfrastructureTestCase extends InfrastructureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $arranger = new MoocEnvironmentArranger($this->service(EntityManager::class));

        $arranger->arrange();
    }

    protected function tearDown(): void
    {
        $arranger = new MoocEnvironmentArranger($this->service(EntityManager::class));

        $arranger->close();

        parent::tearDown();
    }

    protected function clearUnitOfWork()
    {
        $this->service(EntityManager::class)->clear();
    }
}
