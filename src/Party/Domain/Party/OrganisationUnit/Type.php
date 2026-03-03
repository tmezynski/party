<?php

declare(strict_types=1);

namespace Party\Domain\Party\OrganisationUnit;

enum Type: string
{
    case Division = 'division';
    case Department = 'department';
    case Team = 'team';
}
