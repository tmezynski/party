<?php

declare(strict_types=1);

namespace Test\Unit\Party\Domain\Party\Organisation;

use Generator;
use Party\Domain\Party\Organisation\EmptyOrganisationNameException;
use Party\Domain\Party\Organisation\OrganisationName;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class OrganisationNameTest extends TestCase
{
    #[Test]
    public function canNotCreateOrganisationNameWithEmptyName(): void
    {
        $result = false;

        try {
            new OrganisationName(' ');
        } catch (EmptyOrganisationNameException) {
            $result = true;
        }

        Assert::assertTrue($result);
    }

    #[Test]
    public function canCreateOrganisationName(): void
    {
        $sut = new OrganisationName(' Test ');

        Assert::assertInstanceOf(OrganisationName::class, $sut);
        Assert::assertEquals((string)$sut, 'Test');
    }

    #[Test, DataProvider('namesToCompareDataProvider')]
    public function canCompareTwoCompanyNames(
        OrganisationName $name1,
        OrganisationName $name2,
        bool $expectedResult,
    ): void {
        Assert::assertEquals($expectedResult, $name1->equals($name2));
    }

    public static function namesToCompareDataProvider(): Generator
    {
        yield [new OrganisationName(' Test '), new OrganisationName('Test'), true];

        yield [new OrganisationName('Test'), new OrganisationName('Other'), false];
    }
}
