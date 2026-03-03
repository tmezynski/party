<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Party\Domain\Party;

use Party\Domain\Party\Id\Id;
use Party\Domain\Party\Person;
use Party\Domain\Party\Person\PersonalName\PersonName;
use Party\Domain\Party\RegisteredIdentifier\Constraints;
use Party\Domain\Party\RegisteredIdentifier\RegisteredIdentifier;
use Shared\Domain\ValueObject\Uuid\Uuid;
use Utils\Collection\Collection;

final class PersonBuilder
{
    public const string DEFAULT_ID = '9334bca4-ba23-4100-884c-272714814e1d';

    /**
     * @param Collection<RegisteredIdentifier> $registeredIdentifiers
     */
    private function __construct(private Id $id, private PersonName $personName, private Collection $registeredIdentifiers)
    {
    }

    public static function aMale(): self
    {
        /** @var Collection<RegisteredIdentifier> $collection */
        $collection = Collection::of();

        return new self(
            id: new Id(Uuid::fromString(self::DEFAULT_ID)),
            personName: PersonalDataBuilder::aMale()->build(),
            registeredIdentifiers: $collection,
        );
    }

    public function build(): Person
    {
        return new Person(
            id: $this->id,
            personName: $this->personName,
            registeredIdentifiers: $this->registeredIdentifiers,
            constraints: new Constraints([]),
        );
    }
}
