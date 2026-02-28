<?php

declare(strict_types=1);

namespace Party\Domain\Party\RegisteredIdentifier;

use Party\Domain\Party\Party;
use Utils\Collection\Collection;

interface Constraint
{
    /**
     * @param Collection<RegisteredIdentifier> $assignedIdentifiers
     */
    public function assertCanAdd(
        Party $party,
        Collection $assignedIdentifiers,
        RegisteredIdentifier $identifierToAdd,
    ): void;

    /**
     * @param Collection<RegisteredIdentifier> $assignedIdentifiers
     */
    public function assertCanRemove(
        Party $party,
        Collection $assignedIdentifiers,
        RegisteredIdentifier $identifierToRemove,
    ): void;
}
