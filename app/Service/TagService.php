<?php

namespace App\Service;

use App\Helpers\PromptGeminiHelper;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Gemini\Laravel\Facades\Gemini;

class TagService
{
    public function createTag($data): Tag
    {
        return $tag = Tag::firstOrCreate(['name' => \Str::slug($data['name'])]);
    }

    public function generateAiTag($data): array
    {
        $baseTag = Tag::all()->pluck('name')->toArray();
        $prompt = PromptGeminiHelper::generateTag('discussion', $request['content'],$baseTag);
        $result = Gemini::geminiPro()->generateContent($prompt);
        $tags = [];
        foreach (PromptGeminiHelper::convertTag($result->text()) as $tag) {
            $tags[] = Tag::firstOrCreate(['name'=>\Str::slug($tag)]);
        }
        return $tags;
    }

    public function getAllTag(): \Illuminate\Database\Eloquent\Collection|\LaravelIdea\Helper\App\Models\_IH_Tag_C|array
    {
        return Tag::all();
    }
}
