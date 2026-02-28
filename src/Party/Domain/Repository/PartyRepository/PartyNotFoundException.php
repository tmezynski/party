<?php

declare(strict_types=1);

namespace Party\Domain\Repository\PartyRepository;

use Party\Domain\Party\Id\Id;
use Utils\Exception\DetailedException;
use Utils\Exception\ErrorCode;

final class PartyNotFoundException extends DetailedException
{
    public function __construct(Id $id)
    {
        parent::__construct(
            'Party not found',
            ErrorCode::PartyNotFound,
            sprintf('Party with id: "%s" not found.', $id),
        );
    }
}
