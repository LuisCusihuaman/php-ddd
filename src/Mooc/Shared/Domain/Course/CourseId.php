<?php


namespace LuisCusihuaman\Mooc\Shared\Domain\Course;

use LuisCusihuaman\Shared\Domain\ValueObject\Uuid;

final class CourseId extends Uuid
{
    public function equals(Uuid $other): bool
    {
        return $this->value() === $other->value();
    }
}