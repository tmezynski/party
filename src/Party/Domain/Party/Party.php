<?php

declare(strict_types=1);

namespace Party\Domain\Party;

use Party\Domain\Party\Exception\ResultNotRecognizedException;
use Party\Domain\Party\Id\Id;
use Party\Domain\Party\RegisteredIdentifier\Constraints;
use Party\Domain\Party\RegisteredIdentifier\Event\RegisteredIdentifierAdded;
use Party\Domain\Party\RegisteredIdentifier\Event\RegisteredIdentifierRemoved;
use Party\Domain\Party\RegisteredIdentifier\Event\RegisterIdentifierAddSkipped;
use Party\Domain\Party\RegisteredIdentifier\Event\RegisterIdentifierRemoveSkipped;
use Party\Domain\Party\RegisteredIdentifier\RegisteredIdentifier;
use Shared\Domain\Model\AggregateRoot;
use Utils\Collection\Collection;
use Utils\Result\Result;

abstract class Party extends AggregateRoot
{
    /**
     * @param Collection<RegisteredIdentifier> $registeredIdentifiers
     */
    public function __construct(
        protected readonly Id $id,
        protected readonly Collection $registeredIdentifiers,
        protected readonly Constraints $constraints,
    ) {
    }

    public function id(): Id
    {
        return $this->id;
    }

    /**
     * @throws ResultNotRecognizedException
     */
    public function addRegisteredIdentifier(RegisteredIdentifier $registeredIdentifier): Result
    {
        $this->constraints->assertCanAdd($this, $this->registeredIdentifiers, $registeredIdentifier);
        $result = $this->registeredIdentifiers->add($registeredIdentifier);

        $event = match (true) {
            $result->isSuccess() => new RegisteredIdentifierAdded($this->id(), $registeredIdentifier),
            $result->isSkipped() => new RegisterIdentifierAddSkipped($this->id(), $registeredIdentifier),
            default => throw ResultNotRecognizedException::onAdding($this->id(), $registeredIdentifier, $result),
        };

        $this->recordThat($event);

        return $result;
    }

    /**
     * @throws ResultNotRecognizedException
     */
    public function removeRegisteredIdentifier(RegisteredIdentifier $registeredIdentifier): Result
    {
        $this->constraints->assertCanRemove($this, $this->registeredIdentifiers, $registeredIdentifier);
        $result = $this->registeredIdentifiers->remove($registeredIdentifier);

        $event = match (true) {
            $result->isSuccess() => new RegisteredIdentifierRemoved($this->id(), $registeredIdentifier),
            $result->isSkipped() => new RegisterIdentifierRemoveSkipped($this->id(), $registeredIdentifier),
            default => throw ResultNotRecognizedException::onRemoving($this->id(), $registeredIdentifier, $result),
        };

        $this->recordThat($event);

        return $result;
    }
}
