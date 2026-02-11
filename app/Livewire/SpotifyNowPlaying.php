<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SpotifyNowPlaying extends Component
{
    public User $user;
    public $track = null;
    public $isConnected = false;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->isConnected = !empty($this->user->spotify_token);
        $this->refreshStatus();
    }

    public function refreshStatus()
    {
        if (!$this->isConnected) {
            return;
        }

        // Check if token is expired and refresh if needed
        if ($this->user->spotify_token_expires_at && now()->greaterThan($this->user->spotify_token_expires_at)) {
            $this->refreshSpotifyToken();
        }

        try {
            $response = Http::withToken($this->user->spotify_token)
                ->get('https://api.spotify.com/v1/me/player/currently-playing');

            if ($response->status() === 200 && $response->json()) {
                $data = $response->json();
                if (isset($data['item'])) {
                    $this->track = [
                        'title' => $data['item']['name'],
                        'artist' => $data['item']['artists'][0]['name'],
                        'album' => $data['item']['album']['name'],
                        'image' => $data['item']['album']['images'][0]['url'] ?? null,
                        'is_playing' => $data['is_playing'],
                        'url' => $data['item']['external_urls']['spotify'],
                    ];
                    
                    // Update user record for persistence/other components
                    $this->user->update(['spotify_now_playing' => $this->track]);
                }
            } else {
                $this->track = null;
                $this->user->update(['spotify_now_playing' => null]);
            }
        } catch (\Exception $e) {
            Log::error('Spotify refreshStatus error: ' . $e->getMessage());
            $this->track = null;
        }
    }

    protected function refreshSpotifyToken()
    {
        try {
            $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $this->user->spotify_refresh_token,
                'client_id' => config('services.spotify.client_id'),
                'client_secret' => config('services.spotify.client_secret'),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->user->update([
                    'spotify_token' => $data['access_token'],
                    'spotify_token_expires_at' => now()->addSeconds($data['expires_in']),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Spotify token refresh failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.spotify-now-playing');
    }
}
