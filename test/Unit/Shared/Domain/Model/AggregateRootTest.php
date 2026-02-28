<?php

declare(strict_types=1);

namespace Test\Unit\Shared\Domain\Model;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shared\Domain\Event\SyncEvent;
use Test\Utils\Dsl\Shared\Domain\AggregateRootBuilder;
use Test\Utils\Dsl\Shared\Domain\AssertAggregateRoot;

final class AggregateRootTest extends TestCase
{
    #[Test]
    public function canCreateAggregateRootWithValidVersionAndEmptyEvents(): void
    {
        $sut = AggregateRootBuilder::new()->build();

        AssertAggregateRoot::aAggregate($sut)
            ->isInVersion(0)
            ->hasEvents(0);
    }

    #[Test]
    public function canPropagateEventsFromAggregate(): void
    {
        $sut = AggregateRootBuilder::new()
            ->withEvents($this->createEvent())
            ->build();

        $events = $sut->popEvents();

        Assert::assertCount(1, $events);
        AssertAggregateRoot::aAggregate($sut)
            ->isInVersion(0)
            ->hasEvents(0);
    }

    private function createEvent(): SyncEvent
    {
        return new class implements SyncEvent {
        };
    }
}
