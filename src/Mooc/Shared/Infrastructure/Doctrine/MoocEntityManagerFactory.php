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
     * @throws Exception
     * @throws ORMException
     */
    public static function create(array $parameters, string $environment): EntityManagerInterface
    {
        $isDevMode = 'prod' !== $environment;

        $prefixes = array_merge(
            DoctrinePrefixesSearcher::inPath(__DIR__ . '/../../../../Mooc', 'LuisCusihuaman\Mooc'),
            DoctrinePrefixesSearcher::inPath(__DIR__ . '/../../../../Backoffice', 'LuisCusihuaman\Backoffice')
        );
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
