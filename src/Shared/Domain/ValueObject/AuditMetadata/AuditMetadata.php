<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\AuditMetadata;

use DateTimeImmutable;

final readonly class AuditMetadata
{
    public function __construct(
        public DateTimeImmutable $updatedAt,
        public UserSignature $updatedBy,
        public DateTimeImmutable $createdAt,
        public UserSignature $createdBy,
    ) {
    }

    public function updateWith(DateTimeImmutable $now, UserSignature $userSignature): self
    {
        return new self($now, $userSignature, $this->createdAt, $this->createdBy);
    }
}
