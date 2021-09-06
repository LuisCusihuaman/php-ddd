<?php


namespace LuisCusihuaman\Mooc\CoursesCounter\Domain;

use LuisCusihuaman\Mooc\Shared\Domain\Course\CourseId;
use LuisCusihuaman\Shared\Domain\Aggregate\AggregateRoot;
use function Lambdish\Phunctional\search;

class CoursesCounter extends AggregateRoot
{
    private CoursesCounterTotal $total;
    private array $existingCourses;
    private CoursesCounterId $id;

    public function __construct(CoursesCounterId $id, CoursesCounterTotal $total, CourseId ...$existingCourses)
    {
        $this->id = $id;
        $this->total = $total;
        $this->existingCourses = $existingCourses;
    }

    public static function initialize(CoursesCounterId $id): self
    {
        return new self($id, CoursesCounterTotal::initialize());
    }

    public function hasIncremented(CourseId $courseId): bool
    {
        $existingCourse = search(fn(CourseId $other) => $courseId->equals($other),
            $this->existingCourses());

        return null !== $existingCourse;
    }

    public function increment(CourseId $courseId): void
    {
        $this->total = $this->total->increment();
        $this->existingCourses[] = $courseId;

        $this->record(
            new CoursesCounterIncrementedDomainEvent(
                $this->id()->value(), $this->total()->value()
            ));
    }

    public function id(): CoursesCounterId
    {
        return $this->id;
    }

    public function total(): CoursesCounterTotal
    {
        return $this->total;
    }

    public function existingCourses(): array
    {
        return $this->existingCourses;
    }
}