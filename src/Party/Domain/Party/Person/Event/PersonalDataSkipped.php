<?php

declare(strict_types=1);

namespace Party\Domain\Party\Person\Event;

use Party\Domain\Party\Id\Id;
use Party\Domain\Party\Person\PersonalName\PersonName;
use Shared\Domain\Event\AsyncEvent;

final readonly class PersonalDataSkipped implements AsyncEvent
{
    public function __construct(public Id $id, public PersonName $personalData)
    {
    }
}
