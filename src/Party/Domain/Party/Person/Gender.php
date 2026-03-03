<?php

declare(strict_types=1);

namespace Party\Domain\Party\Person;

enum Gender
{
    case Male;
    case Female;

    // we don't have data
    case Unknown;

    // person has chosen no to specify the gender
    case NotProvided;
}
