<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\DateTime;

final readonly class DateTimeRange
{
    /**
     * @throws DateTimeRangeException
     */
    public function __construct(public DateTime $from, public DateTime $to)
    {
        if ($from->isAfter($to)) {
            throw DateTimeRangeException::validFromIsNotBeforeValidTo($from, $to);
        }
    }
}
