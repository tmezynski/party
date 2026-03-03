<?php

declare(strict_types=1);

namespace Party\Domain\Party\Organisation;

final readonly class OrganisationName
{
    private string $name;

    /**
     * @throws EmptyOrganisationNameException
     */
    public function __construct(string $name)
    {
        $name = trim($name);

        if (empty($name)) {
            throw new EmptyOrganisationNameException();
        }

        $this->name = $name;
    }

    public function equals(self $organisationName): bool
    {
        return $this->name === $organisationName->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
