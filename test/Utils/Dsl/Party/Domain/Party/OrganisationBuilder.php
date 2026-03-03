<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Party\Domain\Party;

use Party\Domain\Party\Id\Id;
use Party\Domain\Party\Organisation;
use Party\Domain\Party\Organisation\OrganisationName;
use Party\Domain\Party\RegisteredIdentifier\Constraints;
use Party\Domain\Party\RegisteredIdentifier\RegisteredIdentifier;
use Shared\Domain\ValueObject\Uuid\Uuid;
use Utils\Collection\Collection;

final class OrganisationBuilder
{
    /**
     * @param Collection<RegisteredIdentifier> $registeredIdentifiers
     */
    public function __construct(
        private Id $id,
        private Collection $registeredIdentifiers,
        private OrganisationName $organisationName,
    ) {
    }

    public static function anOrganisation(): self
    {
        /** @var Collection<RegisteredIdentifier> $collection */
        $collection = Collection::of();

        return new self(
            new Id(Uuid::generateRandom()),
            $collection,
            new OrganisationName('Organisation Name'),
        );
    }

    public function withOrganisationName(OrganisationName $organisationName): self
    {
        $this->organisationName = $organisationName;

        return $this;
    }

    public function build(): Organisation
    {
        return new class (
            $this->id,
            $this->registeredIdentifiers,
            new Constraints([]),
            $this->organisationName,
        ) extends Organisation {
        };
    }
}
