<?php

declare(strict_types=1);

namespace Party\Domain\Party;

use Party\Domain\Party\Id\Id;
use Party\Domain\Party\Person\Event\PersonalDataSkipped;
use Party\Domain\Party\Person\Event\PersonalDataUpdated;
use Party\Domain\Party\Person\PersonalName\PersonName;
use Party\Domain\Party\RegisteredIdentifier\Constraints;
use Utils\Collection\Collection;
use Utils\Result\Result;

final class Person extends Party
{
    public function __construct(
        Id $id,
        private PersonName $personName,
        Collection $registeredIdentifiers,
        Constraints $constraints,
    ) {
        parent::__construct($id, $registeredIdentifiers, $constraints);
    }

    public function updatePersonalData(PersonName $personalData): Result
    {
        if ($this->personName->equals($personalData)) {
            $this->recordThat(new PersonalDataSkipped($this->id(), $personalData));

            return Result::skipped();
        }

        $this->personName = $personalData;
        $this->recordThat(new PersonalDataUpdated($this->id(), $personalData));

        return Result::success();
    }
}
