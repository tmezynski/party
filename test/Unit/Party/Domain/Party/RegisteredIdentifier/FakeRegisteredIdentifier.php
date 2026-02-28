<?php

declare(strict_types=1);

namespace Test\Unit\Party\Domain\Party\RegisteredIdentifier;

use Party\Domain\Party\RegisteredIdentifier\RegisteredIdentifier;
use Party\Domain\Party\RegisteredIdentifier\Type;

final readonly class FakeRegisteredIdentifier implements RegisteredIdentifier
{
    public function __construct(private string $value)
    {
    }

    public function type(): Type
    {
        return Type::IdCard;
    }

    /**
     * @param RegisteredIdentifier $other
     */
    public function equals($other): bool
    {
        return (string) $this === (string) $other;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
