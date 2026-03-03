<?php

declare(strict_types=1);

namespace Test\Unit\Party\Domain\Party\Person;

use Generator;
use Party\Domain\Party\Person\Gender;
use Party\Domain\Party\Person\PersonalName\EmptyPersonalDataException;
use Party\Domain\Party\Person\PersonalName\PersonName;
use Party\Domain\Party\Person\Prefix;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PersonDataTest extends TestCase
{
    #[Test]
    public function canNotCreateEmptyPersonData(): void
    {
        $this->expectException(EmptyPersonalDataException::class);

        new PersonName('', '', '', Gender::Male);
    }

    #[Test]
    public function canCreatePersonalDataInValidState(): void
    {
        $sut = new PersonName(' John ', ' Josh ', ' Doe ', Gender::Male);

        self::assertSame('John', $sut->firstName);
        self::assertSame('Josh', $sut->middleName);
        self::assertSame('Doe', $sut->lastName);
        self::assertSame(Gender::Male, $sut->gender);
    }

    #[Test, DataProvider('comparablePersonalDataDataProvider')]
    public function comparePersonalDataObjectsAreNotEqual(PersonName $sut1, PersonName $sut2, bool $expectedResult): void
    {
        self::assertEquals($expectedResult, $sut1->equals($sut2));
    }

    public static function comparablePersonalDataDataProvider(): Generator
    {
        yield 'Equal objects' => [
            new PersonName('John', 'Doe', 'Smith', Gender::Male),
            new PersonName('John', 'Doe', 'Smith', Gender::Male),
            true,
        ];

        yield 'Different first name' => [
            new PersonName('John', 'Doe', 'Smith', Gender::Male),
            new PersonName('Josh', 'Doe', 'Smith', Gender::Male),
            false,
        ];

        yield 'Different middle name' => [
            new PersonName('John', 'Doe', 'Smith', Gender::Male),
            new PersonName('John', 'Josh', 'Smith', Gender::Male),
            false,
        ];

        yield 'Different last name' => [
            new PersonName('John', 'Doe', 'Smith', Gender::Male),
            new PersonName('John', 'Doe', 'Clash', Gender::Male),
            false,
        ];

        yield 'Different gender' => [
            new PersonName('John', 'Doe', 'Smith', Gender::Male),
            new PersonName('John', 'Doe', 'Smith', Gender::Female),
            false,
        ];

        yield 'Different title' => [
            new PersonName('John', 'Doe', 'Smith', Gender::Male, Prefix::Mr),
            new PersonName('John', 'Doe', 'Smith', Gender::Male, Prefix::Ms),
            false,
        ];
    }
}
