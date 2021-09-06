<?php


namespace LuisCusihuaman\Apps\Mooc\Backend\Controller\Courses;


use LuisCusihuaman\Mooc\Courses\Application\Create\CreateCourseCommand;
use LuisCusihuaman\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CoursesPutController
{
    private $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(string $id, Request $request): Response
    {
        $this->bus->dispatch(
            new CreateCourseCommand(
                $id,
                $request->request->get('name'),
                $request->request->get('duration')
            )
        );

        return new Response("", Response::HTTP_CREATED);
    }
}