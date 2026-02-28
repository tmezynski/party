<?php

declare(strict_types=1);

namespace Utils\Collection;

use Utils\Result\Result;

/**
 * @template T of ComparableInterface
 */
final class Collection
{
    /**
     * @var array<T>
     */
    private array $items = [];

    /**
     * @param array<T> $items
     *
     * @return Collection<T>
     */
    public static function of(...$items): Collection
    {
        /** @var Collection<T> $collection */
        $collection = new self();
        foreach ($items as $item) {
            /** @var T $item */
            $collection->add($item);
        }

        return $collection;
    }

    /**
     * @param T $item
     */
    public function add(ComparableInterface $item): Result
    {
        if (!$this->contains($item)) {
            $this->items[] = $item;

            return Result::success();
        }

        return Result::skipped();
    }

    /**
     * @param T $item
     */
    public function remove(ComparableInterface $item): Result
    {
        if (!$this->contains($item)) {
            return Result::skipped();
        }

        $this->items = array_filter($this->items, fn($value) => !$value->equals($item));

        return Result::success();
    }

    /**
     * @param T $value
     */
    public function contains(ComparableInterface $value): bool
    {
        return array_any($this->items, fn($item) => $item->equals($value));
    }

    public function count(): int
    {
        return count($this->items);
    }
}
