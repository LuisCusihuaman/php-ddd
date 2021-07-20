<?php


namespace LuisCusihuaman\Mooc\CoursesCounter\Application\Find;


use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounterNotExist;
use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounterRepository;

final class CoursesCounterFinder
{
    private $repository;

    public function __construct(CoursesCounterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(): CoursesCounterResponse
    {
        $counter = $this->repository->search();

        if (null === $counter) {
            throw new CoursesCounterNotExist();
        }

        return new CoursesCounterResponse($counter->total()->value());
    }
}
