<?php

declare(strict_types=1);

namespace Test\Unit\Utils\Collection;

use Utils\Collection\ComparableInterface;

/**
 * @template-implements ComparableInterface<FakeItem>
 */
final readonly class FakeItem implements ComparableInterface
{
    public function __construct(private int $value)
    {
    }

    /**
     * @param FakeItem $other
     */
    public function equals($other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
