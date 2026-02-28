<?php

declare(strict_types=1);

namespace Utils\Exception;

use Utils\Enum\EnumTrait;

enum ErrorCode: int
{
    use EnumTrait;

    case SentryCheckException = 999;
    case CurrencyMismatch = 1000;
    case InvalidDecimalValue = 1001;
    case InvalidDecimalPrecisionValue = 1002;
    case DivisionByZero = 1003;
    case InvalidUuidString = 1004;
    case InvalidEnumName = 1005;
    case OptimisticLockException = 1006;
    case UnknownResultWhileAddingRegisteredIdentifier = 2000;
    case UnknownResultWhileRemovingRegisteredIdentifier = 2001;
    case PartyNotFound = 2002;
    case EmptyPersonalData = 2100;

    public function httpCode(): int
    {
        return match ($this) {
            self::InvalidEnumName,
            self::PartyNotFound => 404,
            self::OptimisticLockException => 409,
            default => 500,
        };
    }
}
