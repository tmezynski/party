<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\DateTime;

use DateTimeImmutable;
use DateTimeZone;

final readonly class DateTime
{
    private DateTimeImmutable $datetime;

    public function __construct(DateTimeImmutable $datetime)
    {
        $this->datetime = $datetime->setTimezone(new DateTimeZone('UTC'));
    }

    /**
     * @throws InvalidDateTimeFormatException
     */
    public static function fromString(string $timestamp): DateTime
    {
        $datetime = DateTimeImmutable::createFromFormat(DateTimeImmutable::ATOM, $timestamp);
        if ($datetime instanceof DateTimeImmutable) {
            return new self($datetime);
        }

        throw new InvalidDateTimeFormatException($timestamp);
    }

    public function isAfter(DateTime $compare): bool
    {
        return $this->datetime->getTimestamp() > $compare->datetime->getTimestamp();
    }

    public function __toString(): string
    {
        return $this->datetime->format(DateTimeImmutable::ATOM);
    }
}
