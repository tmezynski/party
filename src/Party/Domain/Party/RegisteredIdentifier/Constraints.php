<?php

declare(strict_types=1);

namespace Party\Domain\Party\RegisteredIdentifier;

use Party\Domain\Party\Party;
use Utils\Collection\Collection;

final readonly class Constraints
{
    /**
     * @param array<Constraint> $constraints
     */
    public function __construct(private array $constraints)
    {
    }

    /**
     * @param Collection<RegisteredIdentifier> $assignedIdentifiers
     */
    public function assertCanAdd(
        Party $party,
        Collection $assignedIdentifiers,
        RegisteredIdentifier $identifierToAdd,
    ): void {
        foreach ($this->constraints as $constraint) {
            $constraint->assertCanAdd($party, $assignedIdentifiers, $identifierToAdd);
        }
    }

    /**
     * @param Collection<RegisteredIdentifier> $assignedIdentifiers
     */
    public function assertCanRemove(
        Party $party,
        Collection $assignedIdentifiers,
        RegisteredIdentifier $identifierToRemove,
    ): void {
        foreach ($this->constraints as $constraint) {
            $constraint->assertCanRemove($party, $assignedIdentifiers, $identifierToRemove);
        }
    }
}
