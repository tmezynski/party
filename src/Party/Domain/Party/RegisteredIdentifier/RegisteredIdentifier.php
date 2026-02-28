<?php

declare(strict_types=1);

namespace Party\Domain\Party\RegisteredIdentifier;

use Stringable;
use Utils\Collection\ComparableInterface;

/**
 * @template-extends ComparableInterface<RegisteredIdentifier>
 */
interface RegisteredIdentifier extends ComparableInterface, Stringable
{
    public function type(): Type;
}
