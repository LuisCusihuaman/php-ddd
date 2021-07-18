<?php


namespace LuisCusihuaman\Tests\Shared\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManager;
use function Lambdish\Phunctional\apply;
use function Lambdish\Phunctional\each;


final class DatabaseConnections
{
    private array $connections = [];

    public function __construct(iterable $connections)
    {
        $this->connections = iterator_to_array($connections);
    }

    public function clear(): void
    {
        each($this->clearer(), $this->connections);
    }

    public function allConnectionsClearer(): callable
    {
        return fn() => $this->clear();
    }

    public function truncate(): void
    {
        apply(new DatabaseCleaner(), array_values($this->connections));
    }

    private function clearer(): callable
    {
        return static fn(EntityManager $entityManager) => $entityManager->clear();
    }
}
