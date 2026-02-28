<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Party\Domain\Party;

use Party\Domain\Party\Person;
use Party\Domain\Party\Person\PersonalData\PersonalData;
use PHPUnit\Framework\Assert;
use Test\Utils\Dsl\Shared\Domain\AssertAggregateTrait;

final class AssertPerson
{
    use AssertAggregateTrait;

    private function __construct(private Person $person)
    {
        $this->setReflection($person);
    }

    public static function aPerson(Person $person): self
    {
        return new self($person);
    }

    public function hasPersonalData(PersonalData $personalData): self
    {
        Assert::assertTrue($this->person->personalData()->equals($personalData));

        return $this;
    }
}
