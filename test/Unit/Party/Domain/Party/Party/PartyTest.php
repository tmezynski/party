<?php

declare(strict_types=1);

namespace Test\Unit\Party\Domain\Party\Party;

use Party\Domain\Party\RegisteredIdentifier\Event\RegisteredIdentifierAdded;
use Party\Domain\Party\RegisteredIdentifier\Event\RegisteredIdentifierRemoved;
use Party\Domain\Party\RegisteredIdentifier\Event\RegisterIdentifierAddSkipped;
use Party\Domain\Party\RegisteredIdentifier\Event\RegisterIdentifierRemoveSkipped;
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
        AssertParty::assertThat($sut)
            ->isInVersion(0)
            ->recordedNumberOfEvents(1)
            ->recordedEvent(new RegisteredIdentifierAdded($sut->id(), $registeredIdentifier));
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
        AssertParty::assertThat($sut)
            ->recordedNumberOfEvents(1)
            ->recordedEvent(new RegisterIdentifierAddSkipped($sut->id(), $registeredIdentifier));
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
        AssertParty::assertThat($sut)
            ->hasRegisteredIdentifiers($registeredIdentifier2)
            ->recordedNumberOfEvents(1)
            ->recordedEvent(new RegisteredIdentifierRemoved($sut->id(), $registeredIdentifier1));
    }

    #[Test]
    public function removeOfNotExistingRegisteredIdentifierIsSkipped(): void
    {
        $registeredIdentifier = new FakeRegisteredIdentifier('abc');
        $sut = PartyBuilder::aParty()->build();

        $result = $sut->removeRegisteredIdentifier($registeredIdentifier);

        self::assertTrue($result->isSkipped());
        AssertParty::assertThat($sut)
            ->recordedNumberOfEvents(1)
            ->recordedEvent(new RegisterIdentifierRemoveSkipped($sut->id(), $registeredIdentifier));
    }
}
