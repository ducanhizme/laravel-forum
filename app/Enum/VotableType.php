<?php

namespace App\Enum;

enum VotableType: string
{
    case UP_VOTE = 'up_vote';
    case DOWN_VOTE = 'down_vote';

    public static function toArray(): array
    {
        return array_column(VotableType::cases(), 'value');
    }
}
