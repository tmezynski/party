<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Party\Domain\Party;

use Party\Domain\Party\RegisteredIdentifier\RegisteredIdentifier;
use Test\Utils\Dsl\Shared\Domain\AssertCollectionTrait;
use Utils\Collection\Collection;

final class AssertRegisteredIdentifierCollection
{
    use AssertCollectionTrait;

    /**
     * @param Collection<RegisteredIdentifier> $registeredIdetifiers
     */
    private function __construct(private Collection $registeredIdetifiers)
    {
        $this->setReflection($this->registeredIdetifiers);
    }

    /**
     * @param Collection<RegisteredIdentifier> $registeredIdentifiers
     */
    public static function aCollection(Collection $registeredIdentifiers): self
    {
        return new self($registeredIdentifiers);
    }
}
