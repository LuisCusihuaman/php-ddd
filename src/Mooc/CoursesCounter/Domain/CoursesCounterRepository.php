<?php


namespace LuisCusihuaman\Mooc\CoursesCounter\Domain;


interface CoursesCounterRepository
{
    public function save(CoursesCounter $counter): void;

    public function search(): ?CoursesCounter;
}