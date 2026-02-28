<?php

declare(strict_types=1);

namespace Party\Domain\Party\Event;

use Party\Domain\Party\Id\Id;
use Party\Domain\Party\RegisteredIdentifier\RegisteredIdentifier;
use Shared\Domain\Event\AsyncEvent;

final class RegisterIdentifierRemoveSkipped implements AsyncEvent
{
    public function __construct(public Id $id, public RegisteredIdentifier $registeredIdentifier)
    {
    }
}
