<?php

declare(strict_types=1);

namespace Party\Domain\Party\Id;

use Shared\Domain\ValueObject\Uuid\Uuid;

final readonly class Id
{
    public function __construct(private Uuid $uuid)
    {
    }

    public function __toString(): string
    {
        return (string)$this->uuid;
    }
}
