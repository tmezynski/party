<?php

declare(strict_types=1);

namespace Utils\Validator;

final class StringHelper
{
    public static function allValuesAreEmpty(string ...$values): bool
    {
        return !array_any($values, fn($value) => !empty(trim($value)));
    }
}
