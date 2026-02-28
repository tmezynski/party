<?php

declare(strict_types=1);

namespace Test\Integration\Shared\Application\Command\FakeCommand;

use PHPUnit\Framework\Attributes\Test;
use Test\Integration\IntegrationTestCase;
use Test\Integration\Shared\Application\Event\FakeEvent\FakeEvent;
use Test\Utils\Dsl\Shared\CommandBusTrait;

final class FakeCommandTest extends IntegrationTestCase
{
    use CommandBusTrait;

    #[Test]
    public function canConsumeTheCommand(): void
    {
        $this->whenTheCommandIsHandled(new FakeCommand(5));

        $this->thenTheEventIsPublished(new FakeEvent(5));
    }
}
