<?php


namespace LuisCusihuaman\Shared\Infrastructure\Persistence\Mappings;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use LuisCusihuaman\Shared\Domain\ValueObject\Uuid;
use LuisCusihuaman\Shared\Infrastructure\Doctrine\Dbal\DoctrineCustomType;

abstract class UuidType extends StringType implements DoctrineCustomType
{
    public function getName(): string
    {
        return static::customTypeName();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $className = $this->typeClassName();

        return new $className($value);
    }

    /** @var Uuid $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->value();
    }

    abstract protected function typeClassName(): string;
}
