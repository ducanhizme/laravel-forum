<?php

namespace App\Enum;

enum DiscussionStatus: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case ARCHIVED = 'archived';

    public static function toArray():array{
        return array_column(DiscussionStatus::cases(), 'value');
    }
}
