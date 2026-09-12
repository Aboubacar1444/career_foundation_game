<?php

declare(strict_types=1);

namespace App\Enum;

enum GameActionStatus: string
{
    case Created = 'created';
    case Running = 'running';
    case SpeedModified = 'speed_modified';
    case Ready = 'ready';
    case Resolved = 'resolved';
}
