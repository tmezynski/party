<?php

declare(strict_types=1);

namespace Party\Domain\Party;

use Party\Domain\Party\Id\Id;
use Party\Domain\Party\Person\Event\PersonalDataSkipped;
use Party\Domain\Party\Person\Event\PersonalDataUpdated;
use Party\Domain\Party\Person\PersonalData\PersonalData;
use Party\Domain\Party\RegisteredIdentifier\Constraints;
use Utils\Collection\Collection;
use Utils\Result\Result;

final class Person extends Party
{
    public function __construct(
        Id $id,
        private PersonalData $personalData,
        Collection $registeredIdentifiers,
        Constraints $constraints,
    ) {
        parent::__construct($id, $registeredIdentifiers, $constraints);
    }

    public function personalData(): PersonalData
    {
        return $this->personalData;
    }

    public function updatePersonalData(PersonalData $personalData): Result
    {
        if ($this->personalData->equals($personalData)) {
            $this->recordThat(new PersonalDataSkipped($this->id(), $personalData));

            return Result::skipped();
        }

        $this->personalData = $personalData;
        $this->recordThat(new PersonalDataUpdated($this->id(), $personalData));

        return Result::success();
    }
}
