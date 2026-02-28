<?php

declare(strict_types=1);

namespace Test\Unit\Party\Domain\Party\Person;

use Party\Domain\Party\Id\Id;
use Party\Domain\Party\Person\Event\PersonalDataSkipped;
use Party\Domain\Party\Person\Event\PersonalDataUpdated;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\Uuid\Uuid;
use Test\Utils\Dsl\Party\Domain\Party\AssertPerson;
use Test\Utils\Dsl\Party\Domain\Party\PersonalDataBuilder;
use Test\Utils\Dsl\Party\Domain\Party\PersonBuilder;

final class PersonTest extends TestCase
{
    #[Test]
    public function skipUpdatePersonalDataWhenUpdatingWithSameValues(): void
    {
        $sut = PersonBuilder::aMale()->build();
        $personalData = $sut->personalData();

        $result = $sut->updatePersonalData($personalData);

        Assert::assertTrue($result->isSkipped());
        AssertPerson::aPerson($sut)
            ->hasPersonalData($personalData)
            ->isInVersion(0)
            ->hasEvents(1)
            ->producedEvent(
                new PersonalDataSkipped(
                    id: new Id(Uuid::fromString(PersonBuilder::DEFAULT_ID)),
                    personalData: $personalData,
                ),
            );
    }

    #[Test]
    public function updatePersonalDataWhenUpdatingWithDifferentValue(): void
    {
        $sut = PersonBuilder::aMale()->build();
        $newPersonalData = PersonalDataBuilder::aFemale()->build();

        $result = $sut->updatePersonalData($newPersonalData);

        Assert::assertTrue($result->isSuccess());
        AssertPerson::aPerson($sut)
            ->hasPersonalData($newPersonalData)
            ->isInVersion(0)
            ->hasEvents(1)
            ->producedEvent(
                new PersonalDataUpdated(
                    id: new Id(Uuid::fromString(PersonBuilder::DEFAULT_ID)),
                    personalData: $newPersonalData,
                ),
            );
    }
}
