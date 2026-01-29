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
            // Mock data for UI testing
            return [
                'id' => 'dQw4w9WgXcQ', // Never Gonna Give You Up (Classic placeholder)
                'title' => 'Mock Video - ' . $query,
                'thumbnail' => 'https://i.ytimg.com/vi/dQw4w9WgXcQ/hqdefault.jpg',
            ];
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
