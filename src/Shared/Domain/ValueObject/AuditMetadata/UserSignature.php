<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\AuditMetadata;

use Shared\Domain\ValueObject\Uuid\Uuid;

final readonly class UserSignature
{
    public function __construct(public Uuid $userId, public string $userName)
    {
    }
}
