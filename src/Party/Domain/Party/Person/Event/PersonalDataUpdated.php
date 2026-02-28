<?php

declare(strict_types=1);

namespace Party\Domain\Party\Person\Event;

use Party\Domain\Party\Id\Id;
use Party\Domain\Party\Person\PersonalData\PersonalData;
use Shared\Domain\Event\AsyncEvent;

final readonly class PersonalDataUpdated implements AsyncEvent
{
    public function __construct(public Id $id, public PersonalData $personalData)
    {
    }
}
