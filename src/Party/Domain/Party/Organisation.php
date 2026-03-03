<?php

declare(strict_types=1);

namespace Party\Domain\Party;

use Party\Domain\Party\Id\Id;
use Party\Domain\Party\Organisation\Event\OrganisationNameUpdated;
use Party\Domain\Party\Organisation\Event\OrganisationNameUpdateSkipped;
use Party\Domain\Party\Organisation\OrganisationName;
use Party\Domain\Party\RegisteredIdentifier\Constraints;
use Utils\Collection\Collection;
use Utils\Result\Result;

abstract class Organisation extends Party
{
    public function __construct(
        Id $id,
        Collection $registeredIdentifiers,
        Constraints $constraints,
        protected OrganisationName $organisationName,
    ) {
        parent::__construct($id, $registeredIdentifiers, $constraints);
    }

    public function updateOrganisationName(OrganisationName $organisationName): Result
    {
        if ($this->organisationName->equals($organisationName)) {
            $this->recordThat(new OrganisationNameUpdateSkipped((string)$this->id(), (string)$organisationName));

            return Result::skipped();
        }

        $this->organisationName = $organisationName;
        $this->recordThat(new OrganisationNameUpdated((string)$this->id(), (string)$organisationName));

        return Result::success();
    }
}
