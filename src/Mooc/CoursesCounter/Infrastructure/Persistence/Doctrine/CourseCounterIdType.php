<?php


namespace LuisCusihuaman\Mooc\CoursesCounter\Infrastructure\Persistence\Doctrine;


use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounterId;
use LuisCusihuaman\Shared\Infrastructure\Persistence\Doctrine\UuidType;

class CourseCounterIdType extends UuidType
{

    public static function customTypeName(): string
    {
        return 'course_counter_id';
    }

    protected function typeClassName(): string
    {
        return CoursesCounterId::class;
    }
}