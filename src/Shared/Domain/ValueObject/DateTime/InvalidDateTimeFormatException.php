<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\DateTime;

use Utils\Exception\DetailedException;
use Utils\Exception\ErrorCode;

final class InvalidDateTimeFormatException extends DetailedException
{
    public function __construct(string $dateTime)
    {
        parent::__construct(
            sprintf('Invalid datetime format %s', $dateTime),
            ErrorCode::InvalidDateTimeFormat,
            sprintf('Datetime format should be Y-m-d\TH:i:sP but received %s', $dateTime),
        );
    }
}
