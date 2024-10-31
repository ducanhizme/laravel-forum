<?php

namespace App\Http\Resources;

use App\Models\UserFollower;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin UserFollower */
class UserFollowerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
            'follower_id' => $this->follower_id,
        ];
    }
}
