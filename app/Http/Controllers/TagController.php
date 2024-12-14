<?php

namespace App\Http\Controllers;

use App\Helpers\PromptGeminiHelper;
use App\Http\Requests\TagAiRequest;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Service\TagService;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private TagService $tagService;
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }
    public function createTag(TagRequest $tagRequest)
    {
        $tag = $this->tagService->createTag($tagRequest->validated());
        return $this->respondCreated(new TagResource($tag), 'Tag created successfully');
    }

    public function createTagWithAi(TagAiRequest $request){
        $tags = $this->tagService->generateAiTag($request->validated());
        return $this->respondWithSuccess(TagResource::collection($tags), 'Ai Tags generated successfully');
    }

    public function getAllTag(){
        $tags =$this->tagService->getAllTag();
        return $this->respondWithSuccess(TagResource::collection($tags), 'All tags fetched successfully');
    }
}
