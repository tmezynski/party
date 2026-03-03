<?php

declare(strict_types=1);

namespace Test\Unit\Shared\Domain\ValueObject;

use Generator;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\DateTime\DateTime;
use Shared\Domain\ValueObject\DateTime\InvalidDateTimeFormatException;

final class DateTimeTest extends TestCase
{
    #[Test, DataProvider('validTimestampDataProvider')]
    public function canCreateValidDateTime(string $timestamp, string $expected): void
    {
        $sut = DateTime::fromString($timestamp);

        Assert::assertInstanceOf(DateTime::class, $sut);
        Assert::assertEquals($expected, (string)$sut);
    }

    public static function validTimestampDataProvider(): Generator
    {
        yield ['2005-08-15T15:52:01+00:00', '2005-08-15T15:52:01+00:00'];

        yield ['2005-08-15T15:52:01+04:00', '2005-08-15T11:52:01+00:00'];
    }

    #[Test, DataProvider('invalidTimestampDataProvider')]
    public function canNotCreateDateTimeFromInvalidString(string $timestamp): void
    {
        $result = false;

        try {
            DateTime::fromString($timestamp);
        } catch (InvalidDateTimeFormatException) {
            $result = true;
        }

        Assert::assertTrue($result);
    }

    public static function invalidTimestampDataProvider(): Generator
    {
        yield [''];

        yield ['2026-01-01'];

        yield ['2026-01-01 01:12:33'];

        yield ['2026-01-01T01:12:33'];

        yield ['2026-01-01T01:12:33.0000'];

        yield ['2026-01-01T01:12:33+'];
    }

    #[Test, DataProvider('isAfterDataProvider')]
    public function canCompareIfDatetimeIsAfterOtherDatetime(
        string $datetime1,
        string $datetime2,
        bool $expectedResult,
    ): void {
        $dt1 = DateTime::fromString($datetime1);
        $dt2 = DateTime::fromString($datetime2);

        Assert::assertEquals($expectedResult, $dt1->isAfter($dt2));
    }

    public static function isAfterDataProvider(): Generator
    {
        yield 'equal_same_timezone' => ['2005-08-15T15:52:01+04:00', '2005-08-15T15:52:01+04:00', false];

        yield 'second_after' => ['2005-08-15T15:52:02+00:00', '2005-08-15T15:52:01+00:00', true];

        yield 'minute_after' => ['2005-08-15T15:53:01+00:00', '2005-08-15T15:52:01+00:00', true];

        yield 'hour_after' => ['2005-08-15T16:52:01+00:00', '2005-08-15T15:52:01+00:00', true];

        yield 'day_after' => ['2005-08-16T15:52:01+00:00', '2005-08-15T15:52:01+00:00', true];

        yield 'month_after' => ['2005-09-15T15:52:01+00:00', '2005-08-15T15:52:01+00:00', true];

        yield 'year_after' => ['2006-08-15T15:52:01+00:00', '2005-08-15T15:52:01+00:00', true];

        //        yield 'second_after' => ['2005-08-15T15:52:01+00:00', '2005-08-15T15:52:01+00:00', true];

        //        yield 'same_different_timezone' => ['2005-08-15T16:52:01+04:00', '2005-08-15T15:52:01+03:00', false];

        //        yield 'after_same_timezone' => ['2005-08-15T16:52:01+04:00', '2005-08-15T15:52:01+04:00', false];

        //        yield 'after_different_timezone' => ['2005-08-15T16:52:01+04:00', '2005-08-15T14:52:01+04:00', false];
    }
}
