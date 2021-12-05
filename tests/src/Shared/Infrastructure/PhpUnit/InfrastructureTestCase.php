<?php


namespace LuisCusihuaman\Tests\Shared\Infrastructure\PhpUnit;


use Doctrine\ORM\EntityManager;
use LuisCusihuaman\Tests\Mooc\Shared\Infrastructure\PhpUnit\MoocEnvironmentArranger;
use LuisCusihuaman\Tests\Shared\Domain\TestUtils;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class InfrastructureTestCase extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel(['environment' => 'test']);
        parent::setUp();

        $arranger = new MoocEnvironmentArranger($this->service(EntityManager::class));
        $arranger->arrange();
    }

    /** @return mixed */
    protected function service($id)
    {
        return self::$container->get($id);
    }

    /** @return mixed */
    protected function parameter($parameter)
    {
        return self::$container->getParameter($parameter);
    }

    protected function assertSimilar($expected, $actual): void
    {
        TestUtils::assertSimilar($expected, $actual);
    }

}
