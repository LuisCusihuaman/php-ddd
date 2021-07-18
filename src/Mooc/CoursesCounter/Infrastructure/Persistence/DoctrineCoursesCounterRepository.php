<?php


namespace LuisCusihuaman\Mooc\CoursesCounter\Infrastructure\Persistence;


use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounter;
use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounterRepository;

class DoctrineCoursesCounterRepository implements CoursesCounterRepository
{

    public function save(CoursesCounter $counter): void
    {
        // TODO: Implement save() method.
    }

    public function search(): ?CoursesCounter
    {
        // TODO: Implement search() method.
    }
}