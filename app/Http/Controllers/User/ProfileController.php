<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/profile",
     *     summary="Get user profile",
     *     tags={"Profile"},
     *     @OA\Response(
     *         response=200,
     *         description="Profile retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Profile retrieved successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function getProfile()
    {
        return $this->respondWithSuccess(auth()->user(), 'Profile retrieved successfully');
    }

    /**
     * @OA\Post(
     *     path="/profile/update",
     *     summary="Update user profile",
     *     tags={"Profile"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Profile updated successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function updateProfile(Request $request)
    {
        $currentUser = auth()->user();
        $this->userService->updateUser($currentUser, $request->all());
        return $this->respondWithSuccess($currentUser, 'Profile updated successfully');
    }

    /**
     * @OA\Post(
     *     path="/profile/avatar",
     *     summary="Update user avatar",
     *     tags={"Profile"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="avatar", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Avatar updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Avatar updated successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function updateAvatar(Request $request)
    {
        $currentUser = auth()->user();
        $avatarUrl = config('app.url') . Storage::url($request->file('avatar')->storeAs('avatars', auth()->user()->id, 'public'));
        $this->userService->updateUser($currentUser, ['avatar' => $avatarUrl]);
        return $this->respondWithSuccess(['avatar' => $avatarUrl], 'Avatar updated successfully');
    }
}
