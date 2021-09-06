<?php

namespace LuisCusihuaman\Mooc\Courses\Application\Create;

use LuisCusihuaman\Mooc\Courses\Domain\CourseDuration;
use LuisCusihuaman\Mooc\Courses\Domain\CourseName;
use LuisCusihuaman\Mooc\Shared\Domain\Course\CourseId;
use LuisCusihuaman\Shared\Domain\Bus\Command\CommandHandler;

final class CreateCourseCommandHandler implements CommandHandler
{
    private $creator;

    public function __construct(CourseCreator $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke(CreateCourseCommand $command)
    {
        $id = new CourseId($command->id());
        $name = new CourseName($command->name());
        $duration = new CourseDuration($command->duration());

        $this->creator->__invoke($id, $name, $duration);
    }
}