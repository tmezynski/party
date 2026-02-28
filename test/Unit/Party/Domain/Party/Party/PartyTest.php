<?php

declare(strict_types=1);

namespace Test\Unit\Party\Domain\Party\Party;

use Party\Domain\Party\Event\RegisteredIdentifierAdded;
use Party\Domain\Party\Event\RegisteredIdentifierRemoved;
use Party\Domain\Party\Event\RegisterIdentifierAddSkipped;
use Party\Domain\Party\Event\RegisterIdentifierRemoveSkipped;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Test\Unit\Party\Domain\Party\RegisteredIdentifier\FakeRegisteredIdentifier;
use Test\Utils\Dsl\Party\Domain\Party\AssertParty;
use Test\Utils\Dsl\Party\Domain\Party\PartyBuilder;

final class PartyTest extends TestCase
{
    #[Test]
    public function canAddNewRegisteredIdentifierToParty(): void
    {
        $sut = PartyBuilder::aParty()->build();
        $registeredIdentifier = new FakeRegisteredIdentifier('abc');

        $result = $sut->addRegisteredIdentifier($registeredIdentifier);

        self::assertTrue($result->isSuccess());
        AssertParty::aParty($sut)
            ->isInVersion(0)
            ->hasEvents(1)
            ->producedEvent(new RegisteredIdentifierAdded($sut->id(), $registeredIdentifier));
    }

    #[Test]
    public function addExistingRegisterIdentifierWillBeSkipped(): void
    {
        $registeredIdentifier = new FakeRegisteredIdentifier('abc');
        $sut = PartyBuilder::aParty()
            ->withRegisteredIdentifiers($registeredIdentifier)
            ->build();

        $result = $sut->addRegisteredIdentifier($registeredIdentifier);

        self::assertTrue($result->isSkipped());
        AssertParty::aParty($sut)
            ->hasEvents(1)
            ->producedEvent(new RegisterIdentifierAddSkipped($sut->id(), $registeredIdentifier));
    }

    #[Test]
    public function canRemoveExistingRegisteredIdentifier(): void
    {
        $registeredIdentifier1 = new FakeRegisteredIdentifier('abc');
        $registeredIdentifier2 = new FakeRegisteredIdentifier('xyz');
        $sut = PartyBuilder::aParty()
            ->withRegisteredIdentifiers($registeredIdentifier1, $registeredIdentifier2)
            ->build();

        $result = $sut->removeRegisteredIdentifier($registeredIdentifier1);

        self::assertTrue($result->isSuccess());
        AssertParty::aParty($sut)
            ->hasRegisteredIdentifiers($registeredIdentifier2)
            ->hasEvents(1)
            ->producedEvent(new RegisteredIdentifierRemoved($sut->id(), $registeredIdentifier1));
    }

    #[Test]
    public function removeOfNotExistingRegisteredIdentifierIsSkipped(): void
    {
        $registeredIdentifier = new FakeRegisteredIdentifier('abc');
        $sut = PartyBuilder::aParty()->build();

        $result = $sut->removeRegisteredIdentifier($registeredIdentifier);

        self::assertTrue($result->isSkipped());
        AssertParty::aParty($sut)
            ->hasEvents(1)
            ->producedEvent(new RegisterIdentifierRemoveSkipped($sut->id(), $registeredIdentifier));
    }
}
