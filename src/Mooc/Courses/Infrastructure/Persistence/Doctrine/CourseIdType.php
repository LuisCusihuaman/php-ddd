<?php


namespace LuisCusihuaman\Mooc\Courses\Infrastructure\Persistence\Doctrine;


use LuisCusihuaman\Mooc\Shared\Domain\Course\CourseId;
use LuisCusihuaman\Shared\Infrastructure\Persistence\Doctrine\UuidType;

class CourseIdType extends UuidType
{

    public static function customTypeName(): string
    {
        return 'course_id';
    }

    protected function typeClassName(): string
    {
        return CourseId::class;
    }
}