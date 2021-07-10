<?php


namespace LuisCusihuaman\Mooc\Shared\Infrastructure\Doctrine;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use LuisCusihuaman\Shared\Infrastructure\Doctrine\DoctrineEntityManagerFactory;

final class MoocEntityManagerFactory
{
    private const SCHEMA_PATH = __DIR__ . '/../../../../../databases/mooc.sql';

    /**
     * @throws ORMException
     * @throws Exception
     */
    public static function create(array $parameters, string $environment): EntityManagerInterface
    {
        $isDevMode = 'prod' === $environment;

        $prefixes = DoctrinePrefixesSearcher::inPath(__DIR__ . '/../../../../Mooc', 'CodelyTv\Mooc');
        $dbalCustomTypesClasses = DbalTypesSearcher::inPath(__DIR__ . '/../../../../Mooc', 'Mooc');

        return DoctrineEntityManagerFactory::create(
            $parameters,
            $prefixes,
            $isDevMode,
            self::SCHEMA_PATH,
            $dbalCustomTypesClasses
        );
    }
}
