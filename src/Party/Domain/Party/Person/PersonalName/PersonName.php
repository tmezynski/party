<?php

declare(strict_types=1);

namespace Party\Domain\Party\Person\PersonalName;

use Party\Domain\Party\Person\Gender;
use Party\Domain\Party\Person\Prefix;
use Utils\Validator\StringHelper;

final readonly class PersonName
{
    public string $firstName;
    public string $middleName;
    public string $lastName;
    public ?string $suffix;

    /**
     * @throws EmptyPersonalDataException
     */
    public function __construct(
        string $firstName,
        string $middleName,
        string $lastName,
        public Gender $gender,
        public ?Prefix $prefix = null,
        ?string $suffix = null,
    ) {
        $this->firstName = trim($firstName);
        $this->middleName = trim($middleName);
        $this->lastName = trim($lastName);
        $this->suffix  = null !== $suffix ? trim($suffix) : null;

        $this->assertAtLeastOneFieldNotEmpty();
    }

    public function equals(PersonName $personName): bool
    {
        return $this->firstName === $personName->firstName
            && $this->middleName === $personName->middleName
            && $this->lastName === $personName->lastName
            && $this->gender === $personName->gender
            && $this->prefix === $personName->prefix
            && $this->suffix === $personName->suffix;
    }

    /**
     * @throws EmptyPersonalDataException
     */
    private function assertAtLeastOneFieldNotEmpty(): void
    {
        if (StringHelper::allValuesAreEmpty($this->firstName, $this->lastName)) {
            throw new EmptyPersonalDataException();
        }
    }
}
