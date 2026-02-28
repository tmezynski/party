<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Party\Domain\Party;

use Party\Domain\Party\RegisteredIdentifier\RegisteredIdentifier;
use Utils\Collection\Collection;

final class RegisteredIdentifierCollectionBuilder
{
    /**
     * @return Collection<RegisteredIdentifier>
     */
    public static function aRegisteredIdentifiersWith(RegisteredIdentifier ...$items): Collection
    {
        /** @var Collection<RegisteredIdentifier> $registeredIdentifiers */
        $registeredIdentifiers = new Collection();
        foreach ($items as $item) {
            $registeredIdentifiers->add($item);
        }

        return $registeredIdentifiers;
    }
}
