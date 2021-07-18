<?php


namespace LuisCusihuaman\Tests\Shared\Infrastructure\PhpUnit;


use LuisCusihuaman\Shared\Domain\Bus\DomainEvent;
use LuisCusihuaman\Shared\Domain\Bus\DomainEventPublisher;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class UnitTestCase extends TestCase
{
    private $domainEventPublisher;

    protected function shouldPublishDomainEvent(DomainEvent $domainEvent): void
    {
        // withAnyParameters insted of with(domainEvent) because we can't compare the body
        $this->domainEventPublisher()->method('publish')->withAnyParameters();
    }

    /** @return DomainEventPublisher|MockObject */
    protected function domainEventPublisher(): MockObject
    {
        return $this->domainEventPublisher = $this->domainEventPublisher
            ?: $this->createMock(DomainEventPublisher::class);
    }
}