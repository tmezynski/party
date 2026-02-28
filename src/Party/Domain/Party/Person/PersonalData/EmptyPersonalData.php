<?php

declare(strict_types=1);

namespace Party\Domain\Party\Person\PersonalData;

use Utils\Exception\DetailedException;
use Utils\Exception\ErrorCode;

final class EmptyPersonalData extends DetailedException
{
    public function __construct()
    {
        parent::__construct(
            'Personal data cannot be empty',
            ErrorCode::EmptyPersonalData,
            'Personal data cannot be empty',
        );
    }
}
