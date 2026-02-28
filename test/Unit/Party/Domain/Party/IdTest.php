<?php

declare(strict_types=1);

namespace Test\Unit\Party\Domain\Party;

use Party\Domain\Party\Id\Id;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\Uuid\Uuid;

final class IdTest extends TestCase
{
    #[Test]
    public function shouldConvertIdToString(): void
    {
        $id = new Id(Uuid::fromString('6cc14cdb-0851-4674-814c-db0851d674af'));

        Assert::assertEquals('6cc14cdb-0851-4674-814c-db0851d674af', (string) $id);
    }
}
