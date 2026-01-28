<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class YouTubeService
{
    protected $baseUrl = 'https://www.googleapis.com/youtube/v3';
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key');
    }

    public function searchVideo(string $query)
    {
        if (empty($this->apiKey)) {
            return null;
        }

        $response = Http::get("{$this->baseUrl}/search", [
            'part' => 'snippet',
            'q' => $query,
            'type' => 'video',
            'key' => $this->apiKey,
            'maxResults' => 1,
        ]);

        if ($response->successful()) {
            $items = $response->json('items');
            if (!empty($items)) {
                return [
                    'id' => $items[0]['id']['videoId'],
                    'title' => $items[0]['snippet']['title'],
                    'thumbnail' => $items[0]['snippet']['thumbnails']['high']['url'] ?? null,
                ];
            }
        }

        return null;
    }
}
