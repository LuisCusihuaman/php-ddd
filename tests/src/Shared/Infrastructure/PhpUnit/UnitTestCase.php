<?php


namespace LuisCusihuaman\Tests\Shared\Infrastructure\PhpUnit;


use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEventPublisher;
use LuisCusihuaman\Shared\Domain\UuidGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class UnitTestCase extends TestCase
{
    private $domainEventPublisher;
    private $uuidGenerator;

    protected function shouldPublishDomainEvent(DomainEvent $domainEvent): void
    {
        $this->domainEventPublisher()->method('publish')->withAnyParameters();
    }

    /** @return DomainEventPublisher|MockObject */
    protected function domainEventPublisher(): MockObject
    {
        return $this->domainEventPublisher = $this->domainEventPublisher
            ?: $this->createMock(DomainEventPublisher::class);
    }

    protected function shouldGenerateUuid(string $uuid): void
    {
        $this->uuidGenerator()->method('generate')->willReturn($uuid);
    }

    /** @return UuidGenerator|MockObject */
    protected function uuidGenerator(): MockObject
    {
        return $this->uuidGenerator = $this->uuidGenerator
            ?: $this->createMock(UuidGenerator::class);
    }

    protected function notify(DomainEvent $event, callable $subscriber): void
    {
        $subscriber($event);
    }
}
