<?php

namespace App\Trait;

use App\Models\Comment;

trait Commentable
{

    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function comment($data): void
    {
        $this->comments()->create($data);
    }
}
