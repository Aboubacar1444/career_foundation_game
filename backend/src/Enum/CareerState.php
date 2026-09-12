<?php

declare(strict_types=1);

namespace App\Enum;

enum CareerState: string
{
    case Stable = 'stable';
    case Warning = 'warning';
    case Declining = 'declining';
    case Crisis = 'crisis';
    case Recovery = 'recovery';
}
