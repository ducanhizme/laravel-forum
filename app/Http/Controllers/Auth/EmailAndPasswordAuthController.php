<?php

namespace App\Http\Controllers\Auth;

use App\Events\RegisteredEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Service\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Password;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Authentication related endpoints"
 * )
 */
class EmailAndPasswordAuthController extends Controller
{

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * @OA\Post(
     *     path="/auth/register",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful registration",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Registration complete! You're almost there—please check your inbox to verify the email address you provided and activate your account."),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function register(RegisterRequest $request)
    {
        $userRegistered = $this->userService->registerUser($request);
        event(new RegisteredEvent($userRegistered));
        return $this->respondCreated($userRegistered,"Registration complete! You're almost there—please check your inbox to verify the email address you provided and activate your account.");
    }

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     summary="Login a user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Welcome back! You’ve successfully logged in. Let’s dive in!"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid credentials")
     *         )
     *     )
     * )
     */
    public function login(LoginRequest $request){
        $userLogin = $this->userService->loginUser($request);
        return $this->respondWithSuccess($userLogin,'Welcome back! You’ve successfully logged in. Let’s dive in!');
    }
    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     summary="Logout a user",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful logout",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="You have been successfully logged out")
     *         )
     *     )
     * )
     */
    public function logout(){
        auth()->user()->tokens()->delete();
        return $this->respondOk('You have been successfully logged out');
    }

    /**
     * @OA\Post(
     *     path="/auth/verify-email",
     *     summary="Verify email address",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Email verified successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Email verified successfully! Your account is now fully active. Welcome aboard!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid request")
     *         )
     *     )
     * )
     */
    public function verifyEmail(EmailVerificationRequest $request){
        $request->fulfill();
        return $this->respondOk('Email verified successfully! Your account is now fully active. Welcome aboard!');
    }

    /**
     * @OA\Post(
     *     path="/auth/resend-verification-email",
     *     summary="Resend verification email",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Verification email sent successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Verification email sent successfully! Please check your inbox to confirm your email and complete the setup.")
     *         )
     *     )
     * )
     */
    public function resendVerificationEmail(){
        auth()->user()->sendEmailVerificationNotification();
        return $this->respondOk('Verification email sent successfully! Please check your inbox to confirm your email and complete the setup.');
    }
    /**
     * @OA\Post(
     *     path="/auth/forgot-password",
     *     summary="Send forgot password link",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset link sent",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Password reset link sent to your email")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Failed to send password reset link",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to send password reset link")
     *         )
     *     )
     * )
     */
    public function sendForgotPasswordLink(\Illuminate\Http\Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);
        $msg = Password::sendResetLink($request->only('email'));
        return $this->respondOk($msg===Password::RESET_LINK_SENT ? 'Password reset link sent to your email' : 'Failed to send password reset link');
    }

    /**
     * @OA\Post(
     *     path="/auth/reset-password",
     *     summary="Reset user password",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ResetPasswordRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Password reset successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Failed to reset password",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to reset password")
     *         )
     *     )
     * )
     */
    public function resetPassword(ResetPasswordRequest $request){
        $msg = $this->userService->resetPassword($request);
        return $this->respondOk($msg === Password::PASSWORD_RESET ? 'Password reset successfully' : 'Failed to reset password');
    }
}
