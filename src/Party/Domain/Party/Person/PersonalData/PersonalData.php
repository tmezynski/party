<?php

declare(strict_types=1);

namespace Party\Domain\Party\Person\PersonalData;

use Party\Domain\Party\Person\Gender;
use Party\Domain\Party\Person\Title;

final readonly class PersonalData
{
    public string $firstName;
    public string $middleName;
    public string $lastName;

    /**
     * @throws EmptyPersonalData
     */
    public function __construct(
        string $firstName,
        string $middleName,
        string $lastName,
        public Gender $gender,
        public ?Title $title = null,
    ) {
        $this->firstName = trim($firstName);
        $this->middleName = trim($middleName);
        $this->lastName = trim($lastName);

        $this->assertAtLeastOneFieldNotEmpty();
    }

    public function equals(PersonalData $personalData): bool
    {
        return $this->firstName === $personalData->firstName
            && $this->middleName === $personalData->middleName
            && $this->lastName === $personalData->lastName
            && $this->gender === $personalData->gender
            && $this->title === $personalData->title;
    }

    /**
     * @throws EmptyPersonalData
     */
    private function assertAtLeastOneFieldNotEmpty(): void
    {
        if (empty($this->firstName) && empty($this->lastName)) {
            throw new EmptyPersonalData();
        }
    }
}
