<?php

declare(strict_types=1);

namespace Party\Domain\Party;

use Party\Domain\Party\Id\Id;
use Party\Domain\Party\Organisation\OrganisationName;
use Party\Domain\Party\OrganisationUnit\Type;
use Party\Domain\Party\RegisteredIdentifier\Constraints;
use Utils\Collection\Collection;

final class OrganisationUnit extends Organisation
{
    public function __construct(
        Id $id,
        Collection $registeredIdentifiers,
        Constraints $constraints,
        protected OrganisationName $organisationName,
        protected Type $type,
    ) {
        parent::__construct(
            $id,
            $registeredIdentifiers,
            $constraints,
            $this->organisationName,
        );
    }
}
