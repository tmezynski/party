<?php

declare(strict_types=1);

namespace Party\Domain\Party\Organisation\Event;

use Shared\Domain\Event\AsyncEvent;

final class OrganisationNameUpdateSkipped implements AsyncEvent
{
    public function __construct(public string $id, public string $name)
    {
    }
}
