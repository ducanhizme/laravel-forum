<?php

namespace App\Service;

use App\Enum\VotableType;
use App\Models\Discussion;

class DiscussionService
{

    public function getAllDiscussion(): \Illuminate\Database\Eloquent\Collection|\LaravelIdea\Helper\App\Models\_IH_Discussion_C|array
    {
        return Discussion::with(['user','vote','comments'])->latest()->get();
    }
    public function createUserDiscussion($data){
        $discussion = auth()->user()->discussions()->create($data);
        if ($data['tags']){
            $discussion->tags()->sync($data['tags']);
        }
        return $discussion;
    }

    public function getUserDiscussion(){
        return auth()->user()->discussions;
    }

    public function vote(Discussion $discussion,$data): void
    {
        if ($vote = $discussion->vote()->where('user_id', auth()->id())->first()) {
            if ($vote->type == $data['type']) {
                $vote->delete();
            } else {
                $vote->update(['type' => $data['type']]);
            }
        } else {
            $discussion->vote()->create(['type' => $data['type'], 'user_id' => auth()->id()]);
        }
    }

    public function comment(Discussion $discussion, $data): void
    {
        $discussion->comment(array_merge($data, ['user_id' => auth()->id()]));
    }

}
