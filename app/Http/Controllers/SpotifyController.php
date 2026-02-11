<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SpotifyController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('spotify')
            ->scopes(['user-read-currently-playing', 'user-read-playback-state'])
            ->redirect();
    }

    public function callback()
    {
        try {
            $spotifyUser = Socialite::driver('spotify')->user();
            
            $user = Auth::user();
            
            if ($user) {
                /** @var \App\Models\User $user */
                $user->update([
                    'spotify_id' => $spotifyUser->getId(),
                    'spotify_token' => $spotifyUser->token,
                    'spotify_refresh_token' => $spotifyUser->refreshToken,
                    'spotify_token_expires_at' => now()->addSeconds($spotifyUser->expiresIn),
                ]);
            }

            return redirect()->route('profile', ['username' => $user->username])
                ->with('success', 'Spotify connected successfully!');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Spotify Callback Error: ' . $e->getMessage());
            return redirect()->route('dashboard')
                ->with('status', 'Failed to connect Spotify.');
        }
    }
}
