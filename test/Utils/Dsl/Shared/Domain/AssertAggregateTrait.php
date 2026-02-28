<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Shared\Domain;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;
use ReflectionClass;
use Shared\Domain\Event\AsyncEvent;
use Shared\Domain\Event\SyncEvent;
use Shared\Domain\Model\AggregateRoot;

trait AssertAggregateTrait
{
    /**
     * @var ReflectionClass<AggregateRoot>
     */
    private ReflectionClass $reflection;

    private AggregateRoot $object;

    private function setReflection(AggregateRoot $object): void
    {
        $this->object = $object;
        $this->reflection = new ReflectionClass($object);
    }

    public function isInVersion(int $expectedVersion): self
    {
        Assert::assertEquals($expectedVersion, $this->object->version());

        return $this;
    }

    public function hasEvents(int $value): self
    {
        /** @var array<AsyncEvent|SyncEvent> $events */
        $events = $this->getProperty('events');
        Assert::assertCount($value, $events);

        return $this;
    }

    public function producedEvent(AsyncEvent|SyncEvent $expected): self
    {
        /** @var array<AsyncEvent|SyncEvent> $events */
        $events = $this->getProperty('events');
        $found = false;
        foreach ($events as $event) {
            try {
                Assert::assertEquals($expected, $event);
                $found = true;
            } catch (ExpectationFailedException) {
                continue;
            }
        }

        Assert::assertTrue($found, 'Event not found');

        return $this;
    }

    private function getProperty(string $name): mixed
    {
        $property = $this->reflection->getProperty($name);

        return $property->getValue($this->object);
    }
}
