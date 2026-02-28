<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Party\Domain\Party;

use Party\Domain\Party\Party;
use Party\Domain\Party\RegisteredIdentifier\RegisteredIdentifier;
use Test\Utils\Dsl\Shared\Domain\AssertAggregateTrait;
use Utils\Collection\Collection;

final class AssertParty
{
    use AssertAggregateTrait;

    private function __construct(Party $party)
    {
        $this->setReflection($party);
    }

    public static function aParty(Party $party): self
    {
        return new self($party);
    }

    public function hasRegisteredIdentifiers(RegisteredIdentifier ...$expectedRegisteredIdentifiers): self
    {
        /** @var Collection<RegisteredIdentifier> $registeredIdentifiers */
        $registeredIdentifiers = $this->getProperty('registeredIdentifiers');
        AssertRegisteredIdentifierCollection::aCollection($registeredIdentifiers)
            ->contains(...$expectedRegisteredIdentifiers);

        return $this;
    }
}
