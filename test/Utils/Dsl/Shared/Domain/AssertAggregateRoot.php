<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Shared\Domain;

use Shared\Domain\Model\AggregateRoot;

final class AssertAggregateRoot
{
    use AssertAggregateTrait;

    private function __construct(private AggregateRoot $aggregateRoot)
    {
        $this->setReflection($this->aggregateRoot);
    }

    public static function aAggregate(AggregateRoot $aggregateRoot): self
    {
        return new self($aggregateRoot);
    }
}
