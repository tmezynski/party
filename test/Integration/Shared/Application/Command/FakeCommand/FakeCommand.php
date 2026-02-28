<?php

declare(strict_types=1);

namespace Test\Integration\Shared\Application\Command\FakeCommand;

use Shared\Application\Command\SyncCommand;

final readonly class FakeCommand implements SyncCommand
{
    public function __construct(public int $value)
    {
    }
}
