<?php

namespace App\Http\Resources;

use App\Models\Votable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Votable */
class UpVotableResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'votable_id' => $this->upvotable_id,
            'votable_type' => $this->upvotable_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
