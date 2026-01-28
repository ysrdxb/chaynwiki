<?php

namespace App\Services;

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyService
{
    protected $api;

    public function __construct()
    {
        $session = new Session(
            config('services.spotify.client_id'),
            config('services.spotify.client_secret')
        );

        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();

        $this->api = new SpotifyWebAPI();
        $this->api->setAccessToken($accessToken);
    }

    public function searchTrack(string $query)
    {
        $results = $this->api->search($query, 'track', ['limit' => 5]);
        return $results->tracks->items;
    }

    public function getTrack(string $id)
    {
        return $this->api->getTrack($id);
    }
    
    public function getArtist(string $id)
    {
        return $this->api->getArtist($id);
    }
}
