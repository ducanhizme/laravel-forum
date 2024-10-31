<?php

namespace Database\Factories;

use App\Models\Votable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UpvotableFactory extends Factory
{
    protected $model = Votable::class;

    public function definition(): array
    {
        return [
            'upvotable_id' => $this->faker->randomNumber(),
            'upvotable_type' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
