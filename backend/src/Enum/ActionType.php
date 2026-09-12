<?php

declare(strict_types=1);

namespace App\Enum;

enum ActionType: string
{
    case Recording = 'recording';
    case Concert = 'concert';
    case Tour = 'tour';
    case ReleaseCampaign = 'release_campaign';
    case Collaboration = 'collaboration';
    case Other = 'other';
}
