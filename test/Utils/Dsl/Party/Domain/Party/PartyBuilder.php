<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Party\Domain\Party;

use Party\Domain\Party\Id\Id;
use Party\Domain\Party\Party;
use Party\Domain\Party\RegisteredIdentifier\Constraints;
use Party\Domain\Party\RegisteredIdentifier\RegisteredIdentifier;
use Shared\Domain\ValueObject\Uuid\Uuid;
use Utils\Collection\Collection;

final class PartyBuilder
{
    /**
     * @param Collection<RegisteredIdentifier> $registeredIdentifiers
     */
    public function __construct(private Id $id, private Collection $registeredIdentifiers)
    {
    }

    public static function aParty(): self
    {
        /** @var Collection<RegisteredIdentifier> $collection */
        $collection = Collection::of();

        return new self(
            new Id(Uuid::generateRandom()),
            $collection,
        );
    }

    public function withRegisteredIdentifiers(RegisteredIdentifier ...$registeredIdentifiers): self
    {
        /** @var Collection<RegisteredIdentifier> $collection */
        $collection = Collection::of(...$registeredIdentifiers);
        $this->registeredIdentifiers = $collection;

        return $this;
    }

    public function build(): Party
    {
        return new class ($this->id, $this->registeredIdentifiers, new Constraints([])) extends Party {
        };
    }
}
