<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFollowerRequest;
use App\Http\Resources\UserResource;
use App\Service\UserService;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function follow(UserFollowerRequest $request)
    {
       $userId = $request->validated(['user_id']);
        $this->userService->followUser($userId);
        return $this->respondWithSuccess(new UserResource(auth()->user()->load(['followers','following'])), 'User followed successfully');
    }

    public function unfollow(UserFollowerRequest $request){
        $userId = $request->validated(['user_id']);
        $this->userService->unfollowUser($userId);
        return $this->respondWithSuccess(new UserResource(auth()->user()->load(['followers','following'])), 'User unfollowed successfully');
    }

    public function followers(){
        $followers = $this->userService->getFollowers();
        return $this->respondWithSuccess(UserResource::collection($followers), 'Followers retrieved successfully');
    }

    public function following()
    {
        $following= $this->userService->getFollowing();
        return $this->respondWithSuccess(UserResource::collection($following), 'Following retrieved successfully');
    }
}
