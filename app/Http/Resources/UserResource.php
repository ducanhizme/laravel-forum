<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'username' => $this->username,
            'created_at' => $this->created_at,
            'about'=> $this->about,
            'location'=> $this->location,
            'building'=> $this->building,
            'expertise'=> $this->expertise,
            'followers'=>$this->whenLoaded('followers',function (){
                return $this->followers->count();
            }),
            'following'=>$this->whenLoaded('following',function (){
                return $this->following->count();
            }),
        ];
    }
}
