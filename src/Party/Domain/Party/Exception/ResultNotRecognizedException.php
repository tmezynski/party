<?php

declare(strict_types=1);

namespace Party\Domain\Party\Exception;

use Party\Domain\Party\Id\Id;
use Party\Domain\Party\RegisteredIdentifier\RegisteredIdentifier;
use Utils\Exception\DetailedException;
use Utils\Exception\ErrorCode;
use Utils\Result\Result;

final class ResultNotRecognizedException extends DetailedException
{
    public static function onAdding(Id $id, RegisteredIdentifier $registeredIdentifier, Result $result): self
    {
        return new self(
            'Error while adding registered identifier from party.',
            ErrorCode::UnknownResultWhileAddingRegisteredIdentifier,
            sprintf(
                'While adding registered identifier %s from party %s the result of the operation was not recognized. Should be skipped or success but received %s.',
                $id,
                $registeredIdentifier,
                $result->status,
            ),
        );
    }

    public static function onRemoving(Id $id, RegisteredIdentifier $registeredIdentifier, Result $result): self
    {
        return new self(
            'Error while removing registered identifier from party.',
            ErrorCode::UnknownResultWhileRemovingRegisteredIdentifier,
            sprintf(
                'While removing registered identifier %s from party %s the result of the operation was not recognized. Should be skipped or success but received %s.',
                $id,
                $registeredIdentifier,
                $result->status,
            ),
        );
    }
}
