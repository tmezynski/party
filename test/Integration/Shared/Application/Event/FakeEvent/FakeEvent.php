<?php

declare(strict_types=1);

namespace Test\Integration\Shared\Application\Event\FakeEvent;

use Shared\Domain\Event\SyncEvent;

final readonly class FakeEvent implements SyncEvent
{
    public function __construct(public int $value)
    {
    }
}
