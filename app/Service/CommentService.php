<?php

namespace App\Service;

use App\Models\Comment;

class CommentService
{
    public function comment($data): void
    {
        auth()->user()->comments()->create($data);
    }

    public function reply(Comment $comment, $data): void
    {
        $comment->reply()->create($data);
    }
}
