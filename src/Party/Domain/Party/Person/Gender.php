<?php

declare(strict_types=1);

namespace Party\Domain\Party\Person;

enum Gender
{
    case Male;
    case Female;
    case NotProvided;
    case Unknown;
}
