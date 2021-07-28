<?php


namespace LuisCusihuaman\Tests\Mooc\CoursesCounter\Domain;


use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounter;
use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounterId;
use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounterTotal;
use LuisCusihuaman\Mooc\Shared\Domain\Course\CourseId;
use LuisCusihuaman\Tests\Mooc\Courses\Domain\CourseIdMother;
use LuisCusihuaman\Tests\Shared\Domain\Repeater;

final class CoursesCounterMother
{
    public static function create(
        CoursesCounterId $id,
        CoursesCounterTotal $total,
        CourseId ...$existingCourses
    ): CoursesCounter
    {
        return new CoursesCounter($id, $total, ...$existingCourses);
    }

    public static function withOne(CourseId $courseId): CoursesCounter
    {
        return self::create(CourseCounterIdMother::random(), CoursesCounterTotalMother::one(), $courseId);
    }

    public static function incrementing(CoursesCounter $existingCounter, CourseId $courseId): CoursesCounter
    {
        return self::create(
            $existingCounter->id(),
            CoursesCounterTotalMother::create($existingCounter->total()->value() + 1),
            ...array_merge($existingCounter->existingCourses(), [$courseId])
        );
    }

    public static function random(): CoursesCounter
    {
        return self::create(
            CourseCounterIdMother::random(),
            CoursesCounterTotalMother::random(),
            ...Repeater::random(CourseIdMother::creator())
        );
    }
}
