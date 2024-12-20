<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserFollower;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserFollowerFactory extends Factory
{
    protected $model = UserFollower::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'follower_id' => User::factory(),
        ];
    }
}
