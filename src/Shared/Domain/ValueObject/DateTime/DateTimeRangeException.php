<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\DateTime;

use Utils\Exception\DetailedException;
use Utils\Exception\ErrorCode;

final class DateTimeRangeException extends DetailedException
{
    public static function validFromIsNotBeforeValidTo(DateTime $validFrom, DateTime $validTo): self
    {
        return new self(
            'Invalid time range given',
            ErrorCode::DivisionByZero,
            sprintf(
                'Valid from(%s) should be before valid to(%s).',
                $validFrom,
                $validTo,
            ),
        );
    }
}
