<?php


namespace LuisCusihuaman\Mooc\Courses\Infrastructure\Persistence;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use LuisCusihuaman\Mooc\Courses\Domain\Course;
use LuisCusihuaman\Mooc\Courses\Domain\CourseId;
use LuisCusihuaman\Mooc\Courses\Domain\CourseRepository;

final class MySqlCourseRepository implements CourseRepository
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(Course $course): void
    {
        $this->entityManager->persist($course);
        $this->entityManager->flush($course);
    }

    public function search(CourseId $id): ?Course
    {
        return $this->entityManager->getRepository(Course::class)->find($id);
    }
}
