<?php

namespace App\Models;

use App\Trait\Commentable;
use App\Trait\Votable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discussion extends Model
{
    use HasFactory,Votable,Commentable;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
