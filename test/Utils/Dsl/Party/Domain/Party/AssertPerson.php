<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Party\Domain\Party;

use Party\Domain\Party\Person;
use Party\Domain\Party\Person\PersonalName\PersonName;
use PHPUnit\Framework\Assert;
use Test\Utils\Dsl\Shared\Domain\AssertAggregateTrait;

final class AssertPerson
{
    use AssertAggregateTrait;

    private function __construct(Person $person)
    {
        $this->setReflection($person);
    }

    public static function assertThat(Person $person): self
    {
        return new self($person);
    }

    public function hasPersonalData(PersonName $expected): self
    {
        /** @var PersonName $personName */
        $personName = $this->getProperty('personName');
        Assert::assertTrue($personName->equals($expected));

        return $this;
    }
}
