<?php

declare(strict_types=1);

namespace Test\Unit\Utils\Validator;

use Generator;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Utils\Validator\StringHelper;

final class StringValidatorTest extends TestCase
{
    /**
     * @param string[] $value
     */
    #[Test, DataProvider('stringDataProvider')]
    public function shouldReturnValidResult(array $value, bool $expectedResult): void
    {
        Assert::assertEquals($expectedResult, StringHelper::allValuesAreEmpty(...$value));
    }

    public static function stringDataProvider(): Generator
    {
        yield [[''], true];

        yield [[' '], true];

        yield [['', ' '], true];

        yield [['', ' ', ''], true];

        yield [[' ', ' '], true];

        yield [[' a', ' '], false];

        yield [[' ', 'b '], false];

        yield [[' ', '', '1 '], false];
    }
}
