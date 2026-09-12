<?php

declare(strict_types=1);

namespace App\Enum;

enum EventScope: string
{
    case Global = 'global';
    case Market = 'market';
    case Player = 'player';
}
