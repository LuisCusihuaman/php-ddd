<?php


namespace LuisCusihuaman\Mooc\CoursesCounter\Infrastructure\Persistence;


use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounter;
use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounterRepository;
use LuisCusihuaman\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineCoursesCounterRepository extends DoctrineRepository implements CoursesCounterRepository
{

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(CoursesCounter $counter): void
    {
        $this->persist($counter);
    }

    public function search(): ?CoursesCounter
    {
        return $this->repository(CoursesCounter::class)->findOneBy([]);
    }
}