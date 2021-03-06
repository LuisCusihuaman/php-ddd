<?php


namespace LuisCusihuaman\Mooc\CoursesCounter\Infrastructure\Persistence\Doctrine;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use LuisCusihuaman\Mooc\Shared\Domain\Course\CourseId;
use LuisCusihuaman\Shared\Infrastructure\Doctrine\Dbal\DoctrineCustomType;
use function Lambdish\Phunctional\map;

final class CourseIdsType extends JsonType implements DoctrineCustomType
{
    public static function customTypeName(): string
    {
        return 'course_ids';
    }

    public function getName(): string
    {
        return self::customTypeName();
    }

    /** @var CourseId[] $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValue(map($this->values(), $value), $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $scalars = parent::convertToPHPValue($value, $platform);

        return map($this->toCourseId(), $scalars);
    }

    private function values()
    {
        return static fn(CourseId $id) => $id->value();
    }

    private function toCourseId()
    {
        return static fn(string $value) => new CourseId($value);
    }
}
