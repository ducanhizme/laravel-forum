<?php

namespace App\Http\Controllers\Discussion;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\VotableRequest;
use App\Http\Resources\DiscussionResource;
use App\Interface\Reaction;
use App\Models\Comment;
use App\Models\Discussion;
use App\Service\DiscussionService;

class DiscussionController extends Controller
{
    private DiscussionService $discussionService;

    /**
     * @param DiscussionService $discussionService
     */
    public function __construct(DiscussionService $discussionService)
    {
        $this->discussionService = $discussionService;
    }


    public function index()
    {
        $discussion = $this->discussionService->getAllDiscussion();
        return $this->respondWithSuccess(DiscussionResource::collection($discussion), 'Discussion List');
    }

    public function vote(Discussion $discussion, VotableRequest $request)
    {
        $this->discussionService->vote($discussion, $request->validated());
        return $this->respondOk('Vote added successfully');
    }

    public function comment(Discussion $discussion, CommentRequest $request)
    {
        $this->discussionService->comment($discussion, $request->validated());
        return $this->respondWithSuccess(null, 'Comment Added');
    }

    public function reply(Discussion $discussion, Comment $comment, CommentRequest $request)
    {
        $comment->comments()->create(array_merge($request->validated(), [
            'user_id' => auth()->id(),
            'commentable_type' => get_class($comment),
            'commentable_id' => $comment->id
        ]));
        return $this->respondWithSuccess(null, 'Reply Added');
    }
}
