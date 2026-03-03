<?php

declare(strict_types=1);

namespace Test\Unit\Shared\Domain\ValueObject;

use Generator;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\DateTime\DateTime;
use Shared\Domain\ValueObject\DateTime\DateTimeRange;
use Shared\Domain\ValueObject\DateTime\DateTimeRangeException;

final class DateTimeRangeTest extends TestCase
{
    #[Test]
    public function canNotCreateDateTimeRangeInInvalidState(): void
    {
        $result = false;

        try {
            new DateTimeRange(
                DateTime::fromString('2005-08-15T15:52:01+00:00'),
                DateTime::fromString('2005-08-15T15:52:00+00:00'),
            );
        } catch (DateTimeRangeException) {
            $result = true;
        }

        Assert::assertTrue($result);
    }

    #[Test, DataProvider('validDateRangeDataProvider')]
    public function canCreateDateTimeRangeInValidState(DateTime $from, DateTime $to): void
    {
        $datetime = new DateTimeRange($from, $to);

        Assert::assertInstanceOf(DateTimeRange::class, $datetime);
        Assert::assertEquals((string) $from, $datetime->from);
        Assert::assertEquals((string) $to, $datetime->to);
    }

    public static function validDateRangeDataProvider(): Generator
    {
        yield [
            DateTime::fromString('2005-08-15T15:52:00+00:00'),
            DateTime::fromString('2005-08-15T15:52:00+00:00'),
        ];

        yield [
            DateTime::fromString('2005-08-15T15:52:00+00:00'),
            DateTime::fromString('2005-08-15T15:52:01+00:00'),
        ];
    }
}
