<?php

declare(strict_types=1);

namespace Utils\Result;

final readonly class Result
{
    private const int STATUS_FAILURE = -1;
    private const int STATUS_SKIPPED = 0;
    private const int STATUS_SUCCESS = 1;

    private function __construct(public int $status)
    {
    }

    public static function success(): self
    {
        return new self(self::STATUS_SUCCESS);
    }

    public static function skipped(): self
    {
        return new self(self::STATUS_SKIPPED);
    }

    public static function failure(): self
    {
        return new self(self::STATUS_FAILURE);
    }

    public function isSuccess(): bool
    {
        return self::STATUS_SUCCESS === $this->status;
    }

    public function isSkipped(): bool
    {
        return self::STATUS_SKIPPED === $this->status;
    }

    public function isFailure(): bool
    {
        return self::STATUS_FAILURE === $this->status;
    }
}
