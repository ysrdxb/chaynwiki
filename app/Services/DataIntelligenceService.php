<?php

namespace App\Services;

use Illuminate\Support\Str;

class DataIntelligenceService
{
    protected $spotify;
    protected $youtube;

    public function __construct(SpotifyService $spotify, YouTubeService $youtube)
    {
        $this->spotify = $spotify;
        $this->youtube = $youtube;
    }

    /**
     * Determine the type of URL and fetch metadata accordingly.
     */
    public function fetchFromLink(string $url): array
    {
        if (Str::contains($url, ['spotify.com', 'open.spotify.com'])) {
            return $this->fetchFromSpotify($url);
        }

        if (Str::contains($url, ['youtube.com', 'youtu.be'])) {
            return $this->fetchFromYouTube($url);
        }

        return [
            'success' => false,
            'message' => 'Unsupported source protocol. Please use Spotify or YouTube URLs.'
        ];
    }

    protected function fetchFromSpotify(string $url): array
    {
        // Extract ID and Type (track/artist/album)
        // Format: https://open.spotify.com/track/4uLU61CqPb9vceDU9QHjXF
        preg_match('/(track|artist|album)\/([a-zA-Z0-9]+)/', $url, $matches);
        
        if (empty($matches)) {
            return ['success' => false, 'message' => 'Invalid Spotify URL structure.'];
        }

        $type = $matches[1];
        $id = $matches[2];

        try {
            switch ($type) {
                case 'track':
                    $track = $this->spotify->getTrack($id);
                    $data = [
                        'title' => $track->name,
                        'artist' => $track->artists[0]->name,
                        'album' => $track->album->name,
                        'release_date' => $track->album->release_date,
                        'image' => $track->album->images[0]->url ?? null,
                        'spotify_id' => $id,
                    ];

                    // Intelligent Fallback: Search YouTube for the video equivalent
                    $query = $data['artist'] . ' - ' . $data['title'] . ' Official Video';
                    $video = $this->youtube->searchVideo($query);
                    if ($video) {
                        $data['youtube_id'] = $video['id'];
                    }

                    return [
                        'success' => true,
                        'category' => 'song',
                        'data' => $data
                    ];
                case 'artist':
                    $artist = $this->spotify->getArtist($id);
                    return [
                        'success' => true,
                        'category' => 'artist',
                        'data' => [
                            'title' => $artist->name,
                            'genres' => $artist->genres,
                            'image' => $artist->images[0]->url ?? null,
                            'followers' => $artist->followers->total,
                            'spotify_id' => $id,
                        ]
                    ];
                default:
                    return ['success' => false, 'message' => 'Category mapping for ' . $type . ' not yet implemented.'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Spotify API Error: ' . $e->getMessage()];
        }
    }

    protected function fetchFromYouTube(string $url): array
    {
        // Extract ID
        // Format: https://www.youtube.com/watch?v=dQw4w9WgXcQ or https://youtu.be/dQw4w9WgXcQ
        $videoId = null;
        if (Str::contains($url, 'youtu.be')) {
            $videoId = substr(parse_url($url, PHP_URL_PATH), 1);
        } else {
            parse_str(parse_url($url, PHP_URL_QUERY), $query);
            $videoId = $query['v'] ?? null;
        }

        if (!$videoId) {
            return ['success' => false, 'message' => 'Could not extract YouTube Video ID.'];
        }

        // We use the search service to get snippet info since getTrack equivalent isn't there
        // In a real app we'd use YouTube's 'videos' endpoint
        $video = $this->youtube->searchVideo($videoId);
        
        if (!$video) {
            return ['success' => false, 'message' => 'YouTube Retrieval Failed.'];
        }

        return [
            'success' => true,
            'category' => 'song',
            'data' => [
                'title' => $video['title'],
                'image' => $video['thumbnail'],
                'youtube_id' => $videoId,
            ]
        ];
    }
}
