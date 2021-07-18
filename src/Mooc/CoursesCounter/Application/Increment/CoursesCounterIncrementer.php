<?php


namespace LuisCusihuaman\Mooc\CoursesCounter\Application\Increment;


use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounter;
use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounterId;
use LuisCusihuaman\Mooc\CoursesCounter\Domain\CoursesCounterRepository;
use LuisCusihuaman\Mooc\Shared\Domain\Course\CourseId;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEventPublisher;
use LuisCusihuaman\Shared\Domain\UuidGenerator;

final class CoursesCounterIncrementer
{
    private CoursesCounterRepository $repository;
    private UuidGenerator $uuidGenerator;
    private DomainEventPublisher $publisher;

    public function __construct(
        CoursesCounterRepository $repository,
        UuidGenerator $uuidGenerator,
        DomainEventPublisher $publisher
    )
    {
        $this->repository = $repository;
        $this->uuidGenerator = $uuidGenerator;
        $this->publisher = $publisher;
    }

    private function initializeCounter(): CoursesCounter
    {
        return CoursesCounter::initialize(new CoursesCounterId($this->uuidGenerator->generate()));
    }

    public function __invoke(CourseId $courseId)
    {
        $counter = $this->repository->search() ?: $this->initializeCounter();
        if (!$counter->hasIncremented($courseId)) {
            $counter->increment($courseId);

            $this->repository->save($counter);
            $this->publisher->publish(...$counter->pullDomainEvents());
        }
    }
}