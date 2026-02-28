<?php

declare(strict_types=1);

namespace Party\Domain\Repository\PartyRepository;

use Party\Domain\Party\Id\Id;
use Party\Domain\Party\Party;
use Utils\Exception\OptimisticLockException;

interface PartyRepository
{
    /**
     * @throws OptimisticLockException
     */
    public function save(Party $party): void;

    /**
     * @throws PartyNotFoundException
     */
    public function get(Id $id): Party;
}
