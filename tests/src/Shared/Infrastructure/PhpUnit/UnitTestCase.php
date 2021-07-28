<?php


namespace LuisCusihuaman\Tests\Shared\Infrastructure\PhpUnit;


use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEvent;
use LuisCusihuaman\Shared\Domain\Bus\Event\DomainEventPublisher;
use LuisCusihuaman\Shared\Domain\UuidGenerator;
use LuisCusihuaman\Tests\Shared\Domain\TestUtils;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Matcher\MatcherAbstract;
use Mockery\MockInterface;

abstract class UnitTestCase extends MockeryTestCase
{
    private $domainEventPublisher;
    private $uuidGenerator;

    protected function mock(string $className): MockInterface
    {
        return Mockery::mock($className);
    }

    /** @return DomainEventPublisher|MockInterface */
    protected function domainEventPublisher(): MockInterface
    {
        return $this->domainEventPublisher = $this->domainEventPublisher
            ?: $this->mock(DomainEventPublisher::class);
    }

    /** @return UuidGenerator|MockInterface */
    protected function uuidGenerator(): MockInterface
    {
        return $this->uuidGenerator = $this->uuidGenerator
            ?: $this->mock(UuidGenerator::class);
    }

    protected function shouldPublishDomainEvent(DomainEvent $domainEvent): void
    {
        $this->domainEventPublisher()
            ->shouldReceive('publish')
            ->with($this->similarTo($domainEvent))
            ->andReturnNull();
    }

    protected function shouldGenerateUuid(string $uuid): void
    {
        $this->uuidGenerator()
            ->shouldReceive('generate')
            ->once()
            ->withNoArgs()
            ->andReturn($uuid);
    }

    protected function similarTo($value, $delta = 0.0): MatcherAbstract
    {
        return TestUtils::similarTo($value, $delta);
    }

    protected function notify(DomainEvent $event, callable $subscriber): void
    {
        $subscriber($event);
    }
}
