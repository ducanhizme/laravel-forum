<?php

namespace App\Http\Controllers\Discussion;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscussionRequest;
use App\Http\Requests\VotableRequest;
use App\Http\Resources\DiscussionResource;
use App\Models\Discussion;
use App\Service\DiscussionService;

class UserDiscussionController extends Controller
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
        $discussions = $this->discussionService->getUserDiscussion()->load('vote');
        return $this->respondWithSuccess( DiscussionResource::collection($discussions), 'User discussions fetched successfully');
    }

    public function store(DiscussionRequest $request){
        $discussion = $this->discussionService->createUserDiscussion($request->validated());
        return $this->respondCreated(new DiscussionResource($discussion->load('upVote')), 'Discussion created successfully');
    }

    public function destroy(Discussion $discussion){
        $discussion->delete();
        return $this->respondOk( 'Discussion deleted successfully');
    }

    public function update(DiscussionRequest $request, Discussion $discussion){
        $discussion->update($request->validated());
        return $this->respondWithSuccess(new DiscussionResource($discussion->load('upVote')), 'Discussion updated successfully');
    }
}
