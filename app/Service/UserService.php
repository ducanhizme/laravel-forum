<?php

namespace App\Service;

use App\Enum\TokenAbilities;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class UserService
{
    public function registerUser(RegisterRequest $data){
        return  User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password),
        ]);
    }

    public function loginUser(LoginRequest $request): array
    {
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $accessToken = $user->createToken('accessToken',[TokenAbilities::ACCESS_API],now()->addMinute(config('sanctum.ac_expiration')))->plainTextToken;
            $refreshToken = $user->createToken('refreshToken',[TokenAbilities::ISSUE_ACCESS],now()->addMinute(config('sanctum.rt_expiration')))->plainTextToken;
            return [
                'data' => $user,
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken
            ];
        }else{
            throw new UnauthorizedException('Invalid credentials');
        }
    }

    public function updateUser(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $credentials =[
            'email' => $request->query('email'),
            'token' => $request->query('token'),
            'password' => $request->password,
        ];
        return \Password::reset($credentials, function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password)
            ])->save();
            event(new PasswordReset($user));
        });
    }

    public function followUser($userId):void
    {
         auth()->user()->following()->sync($userId);
    }

    public function getFollowers(): \Illuminate\Database\Eloquent\Collection
    {
        return auth()->user()->followers;
    }

    public function getFollowing()
    {
        return auth()->user()->following;
    }

    public function unfollowUser($userId): void
    {
        auth()->user()->following()->detach($userId);
    }
}
