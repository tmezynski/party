<?php

declare(strict_types=1);

namespace Test\Unit\Party\Domain\Party\Person;

use Generator;
use Party\Domain\Party\Person\Gender;
use Party\Domain\Party\Person\PersonalData\EmptyPersonalData;
use Party\Domain\Party\Person\PersonalData\PersonalData;
use Party\Domain\Party\Person\Title;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PersonDataTest extends TestCase
{
    #[Test]
    public function canNotCreateEmptyPersonData(): void
    {
        $this->expectException(EmptyPersonalData::class);

        new PersonalData('', '', '', Gender::Male);
    }

    #[Test]
    public function canCreatePersonalDataInValidState(): void
    {
        $sut = new PersonalData(' John ', ' Josh ', ' Doe ', Gender::Male);

        self::assertSame('John', $sut->firstName);
        self::assertSame('Josh', $sut->middleName);
        self::assertSame('Doe', $sut->lastName);
        self::assertSame(Gender::Male, $sut->gender);
    }

    #[Test, DataProvider('comparablePersonalDataDataProvider')]
    public function comparePersonalDataObjectsAreNotEqual(PersonalData $sut1, PersonalData $sut2, bool $expectedResult): void
    {
        self::assertEquals($expectedResult, $sut1->equals($sut2));
    }

    public static function comparablePersonalDataDataProvider(): Generator
    {
        yield 'Equal objects' => [
            new PersonalData('John', 'Doe', 'Smith', Gender::Male),
            new PersonalData('John', 'Doe', 'Smith', Gender::Male),
            true,
        ];

        yield 'Different first name' => [
            new PersonalData('John', 'Doe', 'Smith', Gender::Male),
            new PersonalData('Josh', 'Doe', 'Smith', Gender::Male),
            false,
        ];

        yield 'Different middle name' => [
            new PersonalData('John', 'Doe', 'Smith', Gender::Male),
            new PersonalData('John', 'Josh', 'Smith', Gender::Male),
            false,
        ];

        yield 'Different last name' => [
            new PersonalData('John', 'Doe', 'Smith', Gender::Male),
            new PersonalData('John', 'Doe', 'Clash', Gender::Male),
            false,
        ];

        yield 'Different gender' => [
            new PersonalData('John', 'Doe', 'Smith', Gender::Male),
            new PersonalData('John', 'Doe', 'Smith', Gender::Female),
            false,
        ];

        yield 'Different title' => [
            new PersonalData('John', 'Doe', 'Smith', Gender::Male, Title::Mr),
            new PersonalData('John', 'Doe', 'Smith', Gender::Male, Title::Ms),
            false,
        ];
    }
}
