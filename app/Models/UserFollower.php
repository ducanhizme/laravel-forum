<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFollower extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'follower_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
}