<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\Uuid;

use Ramsey\Uuid\Uuid as RamseyUuid;

final readonly class Uuid
{
    private function __construct(private string $value)
    {
        if (!RamseyUuid::isValid($value)) {
            throw new InvalidUuidException($value);
        }
    }

    public static function generateRandom(): self
    {
        return new self((string)RamseyUuid::uuid4());
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public static function fromStringAndNamespace(string $value, string $namespace): self
    {
        if (!RamseyUuid::isValid($value)) {
            throw new InvalidUuidException($value);
        }

        if (!RamseyUuid::isValid($namespace)) {
            throw new InvalidUuidException($namespace);
        }

        return new self((string)RamseyUuid::uuid5($namespace, $value));
    }

    public function equals(self $uuid): bool
    {
        return $this->value === $uuid->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
