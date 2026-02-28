<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Party\Domain\Party;

use Party\Domain\Party\Person\Gender;
use Party\Domain\Party\Person\PersonalData\PersonalData;
use Party\Domain\Party\Person\Title;

final class PersonalDataBuilder
{
    private function __construct(
        private string $firstName,
        private string $middleName,
        private string $lastName,
        private Gender $gender,
        private Title $title,
    ) {
    }

    public static function aMale(): self
    {
        return new self('John', 'Doe', 'Smith', Gender::Male, Title::Mr);
    }

    public static function aFemale(): self
    {
        return new self('Sue', 'B', 'Green', Gender::Female, Title::Ms);
    }

    public function build(): PersonalData
    {
        return new PersonalData(
            $this->firstName,
            $this->middleName,
            $this->lastName,
            $this->gender,
            $this->title,
        );
    }
}
