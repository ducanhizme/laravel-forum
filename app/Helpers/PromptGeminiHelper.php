<?php

namespace App\Helpers;

class PromptGeminiHelper
{
    public static function generateTag(string $type, string $text, ?array $data = null): string
    {
        $basePrompt = "Based on the following {$type}:\n\n{$text}\n\n" .
            "Provide between 1 and 4 tags that accurately describe the content.";
        if ($data) {
            $basePrompt .= " Use existing tags from the data when possible to avoid duplicates.\n\n" .
                "Existing tags data: ". implode(', ', $data) . "\n\n";
        }
        $basePrompt .= "Respond in this format:\n\n" .
            "[tag1, tag2, tag3, tag4]\n\n" .
            "Choose only as many tags as needed for precise description.";

        return $basePrompt;
    }

    public static function convertTag(string $tags): array
    {
        return explode(',', str_replace(['[', ']'], '', $tags));
    }
}
