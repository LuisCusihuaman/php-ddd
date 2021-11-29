<?php

namespace LuisCusihuaman\Backoffice\Courses\Application;

use LuisCusihuaman\Shared\Domain\Bus\Query\Response;

final class BackofficeCoursesResponse implements Response
{
    private $courses;

    public function __construct(BackofficeCourseResponse ...$courses)
    {
        $this->courses = $courses;
    }

    public function courses(): array
    {
        return $this->courses;
    }
}
