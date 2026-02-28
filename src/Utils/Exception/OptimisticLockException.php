<?php

declare(strict_types=1);

namespace Utils\Exception;

final class OptimisticLockException extends DetailedException
{
    public function __construct(int $expectedVersion, int $actualVersion, string $aggregateName)
    {
        parent::__construct(
            'Optimistic lock exception',
            ErrorCode::OptimisticLockException,
            sprintf(
                'Can\'t save aggregate "%s" because of version mismatch. Expected version "%d" but got "%d"',
                $aggregateName,
                $expectedVersion,
                $actualVersion,
            ),
        );
    }
}
