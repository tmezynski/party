<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Shared\Domain;

use Shared\Domain\Event\AsyncEvent;
use Shared\Domain\Event\SyncEvent;
use Shared\Domain\Model\AggregateRoot;

final class AggregateRootBuilder
{
    /**
     * @param AsyncEvent[]|SyncEvent[] $events
     */
    private function __construct(private int $version, private array $events)
    {
    }

    public static function new(): self
    {
        return new self(0, []);
    }

    public function withEvents(AsyncEvent|SyncEvent ...$events): self
    {
        $this->events = $events;

        return $this;
    }

    public function build(): AggregateRoot
    {
        return new class ($this->version, $this->events) extends AggregateRoot {
            /**
             * @param AsyncEvent[]|SyncEvent[] $events
             */
            public function __construct(int $version, array $events)
            {
                $this->version = $version;
                $this->events = $events;
            }
        };
    }
}
