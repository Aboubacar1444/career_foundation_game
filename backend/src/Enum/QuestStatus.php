<?php

declare(strict_types=1);

namespace App\Enum;

enum QuestStatus: string
{
    case Available = 'available';
    case Active = 'active';
    case Completed = 'completed';
    case Failed = 'failed';
}
