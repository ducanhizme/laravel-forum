<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Service\CommentService;

class CommentController extends Controller
{
    private CommentService $commentService;
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function comment(CommentRequest $request)
    {
        $this->commentService->comment($request->validated());
        return $this->respondOk('Comment created successfully');
    }

    public function reply(Comment $comment ,CommentRequest $request)
    {
        $this->commentService->reply($comment,$request->validated());
        return $this->respondOk('Comment replied successfully');
    }
}
