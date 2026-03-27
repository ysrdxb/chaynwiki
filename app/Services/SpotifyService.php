<?php

namespace App\Services;

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyService
{
    protected $initError = null;

    public function __construct()
    {
        try {
            $clientId = config('services.spotify.client_id');
            $clientSecret = config('services.spotify.client_secret');

            if (!$clientId || !$clientSecret) {
                throw new \Exception('Missing Spotify Client ID or Secret in .env config.');
            }

            $session = new Session($clientId, $clientSecret);
    
            $session->requestCredentialsToken();
            $accessToken = $session->getAccessToken();
    
            $this->api = new SpotifyWebAPI();
            $this->api->setAccessToken($accessToken);
        } catch (\Exception $e) {
            // Log error but don't crash app construction
            \Illuminate\Support\Facades\Log::error('Spotify Connection Failed: ' . $e->getMessage());
            $this->api = null;
            $this->initError = $e->getMessage();
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
            throw new \Exception("Spotify API Error: " . ($this->initError ?? 'Unknown connection error'));
        }
        return $this->api->getTrack($id);
    }
    
    public function getArtist(string $id)
    {
        if (!$this->api) {
            throw new \Exception("Spotify API Error: " . ($this->initError ?? 'Unknown connection error'));
        }
        return $this->api->getArtist($id);
    }

    public function getAudioFeatures(string $id)
    {
        if (!$this->api) {
            return null;
        }
        
        try {
            $features = $this->api->getAudioFeatures($id);
            return [
                'tempo' => round($features->tempo),
                'key' => $this->mapSpotifyKeyToNote($features->key) . ($features->mode ? ' Major' : ' Minor'),
                'camelot' => $this->getCamelotKey($features->key, $features->mode),
                'energy' => round($features->energy * 100),
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function mapSpotifyKeyToNote(int $key)
    {
        $keys = ['C', 'C#', 'D', 'Eb', 'E', 'F', 'F#', 'G', 'Ab', 'A', 'Bb', 'B'];
        return $keys[$key] ?? 'Unknown';
    }

    protected function getCamelotKey(int $pitchClass, int $mode)
    {
        // Mode: 1 = Major (B), 0 = Minor (A)
        // Pitch: 0=C, 1=C#...
        
        $majorMap = [
            0 => '8B', 1 => '3B', 2 => '10B', 3 => '5B', 4 => '12B', 5 => '7B', 
            6 => '2B', 7 => '9B', 8 => '4B', 9 => '11B', 10 => '6B', 11 => '1B'
        ];
        
        $minorMap = [
            0 => '5A', 1 => '12A', 2 => '7A', 3 => '2A', 4 => '9A', 5 => '4A', 
            6 => '11A', 7 => '6A', 8 => '1A', 9 => '8A', 10 => '3A', 11 => '10A'
        ];

        if ($mode === 1) {
            return $majorMap[$pitchClass] ?? '';
        } else {
            return $minorMap[$pitchClass] ?? '';
        }
    }
}
