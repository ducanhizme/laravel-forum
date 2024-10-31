<?php

namespace App\Http\Resources;

use App\Enum\VotableType;
use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Discussion */
class DiscussionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'user' => $this->whenLoaded('user', fn() => $this->user),
            'up_votes' => $this->whenLoaded('vote', fn() => $this->vote()->where('type', VotableType::UP_VOTE)->count()),
            'down_votes' => $this->whenLoaded('vote', fn() => $this->vote()->where('type', VotableType::DOWN_VOTE)->count()),
            'comments'=> $this->whenLoaded('comments', function () {
                return CommentResource::collection($this->comments->load('comments'));
            }),
        ];
    }
}
