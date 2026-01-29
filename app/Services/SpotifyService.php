<?php

namespace App\Services;

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyService
{
    protected $api;

    public function __construct()
    {
        try {
            $session = new Session(
                config('services.spotify.client_id'),
                config('services.spotify.client_secret')
            );
    
            $session->requestCredentialsToken();
            $accessToken = $session->getAccessToken();
    
            $this->api = new SpotifyWebAPI();
            $this->api->setAccessToken($accessToken);
        } catch (\Exception $e) {
            // Log error but don't crash app construction
            \Illuminate\Support\Facades\Log::error('Spotify Connection Failed: ' . $e->getMessage());
            $this->api = null;
        }
    }

    public function searchTrack(string $query)
    {
        if (!$this->api) return [];
        
        try {
            $results = $this->api->search($query, 'track', ['limit' => 5]);
            return $results->tracks->items;
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getTrack(string $id)
    {
        if (!$this->api) {
            // Mock data for UI testing
            $mock = new \stdClass();
            $mock->id = 'mock_id_123';
            $mock->name = 'Mock Song Title (Demo)';
            $mock->album = new \stdClass();
            $mock->album->name = 'Demo Album';
            $mock->album->release_date = '2025-01-01';
            $mock->album->images = [];
            
            $artist = new \stdClass();
            $artist->name = 'Demo Artist';
            $mock->artists = [$artist];
            
            return $mock;
        }
        return $this->api->getTrack($id);
    }
    
    public function getArtist(string $id)
    {
        if (!$this->api) {
            // Mock data for UI testing
            $mock = new \stdClass();
            $mock->id = 'mock_artist_123';
            $mock->name = 'Mock Artist (Demo)';
            $mock->genres = ['Rock', 'Pop', 'Indie'];
            $mock->images = [];
            $mock->followers = new \stdClass();
            $mock->followers->total = 1250000;
            
            return $mock;
        }
        return $this->api->getArtist($id);
    }
}
