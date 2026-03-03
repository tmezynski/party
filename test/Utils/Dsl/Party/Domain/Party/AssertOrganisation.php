<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Party\Domain\Party;

use Party\Domain\Party\Organisation;
use Test\Utils\Dsl\Shared\Domain\AssertAggregateTrait;

final class AssertOrganisation
{
    use AssertAggregateTrait;

    private function __construct(Organisation $organisation)
    {
        $this->setReflection($organisation);
    }

    public static function assertThat(Organisation $organisation): self
    {
        return new self($organisation);
    }
}
