<?php

declare(strict_types=1);

namespace App\Enum;

enum MarketTier: string
{
    case Local = 'local';
    case National = 'national';
    case Regional = 'regional';
    case International = 'international';
}
