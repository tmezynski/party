<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Party\Domain\Party;

use Party\Domain\Party\Person\Gender;
use Party\Domain\Party\Person\PersonalName\PersonName;
use Party\Domain\Party\Person\Prefix;

final class PersonalDataBuilder
{
    private function __construct(
        private string $firstName,
        private string $middleName,
        private string $lastName,
        private Gender $gender,
        private Prefix $title,
    ) {
    }

    public static function aMale(): self
    {
        return new self('John', 'Doe', 'Smith', Gender::Male, Prefix::Mr);
    }

    public static function aFemale(): self
    {
        return new self('Sue', 'B', 'Green', Gender::Female, Prefix::Ms);
    }

    public function build(): PersonName
    {
        return new PersonName(
            $this->firstName,
            $this->middleName,
            $this->lastName,
            $this->gender,
            $this->title,
        );
    }
}
