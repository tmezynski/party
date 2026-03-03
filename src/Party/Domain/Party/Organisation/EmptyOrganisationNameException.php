<?php

declare(strict_types=1);

namespace Party\Domain\Party\Organisation;

use Utils\Exception\DetailedException;
use Utils\Exception\ErrorCode;

final class EmptyOrganisationNameException extends DetailedException
{
    public function __construct()
    {
        parent::__construct(
            'Organisation name cannot be empty',
            ErrorCode::DivisionByZero,
            'Organisation name cannot be empty. Please provide a valid organisation name.',
        );
    }
}
