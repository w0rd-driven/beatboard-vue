<?php

namespace App\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Spotify;

class ArtistRepository
{
    public function __construct()
    {

    }

    public function searchArtists($query)
    {
        Log::channel('search')->debug("ArtistSearchRepository: Searching {$query}");

        $response = Spotify::searchArtists($query)->get();
        $items = collect(Arr::get($response, 'artists.items', []));

        // Ideally we'd pick the one with the most followers
        return $items->filter(function ($artist) use ($query) {
            return Arr::get($artist, 'name') === $query && Arr::get($artist, 'type') === 'artist';
        })?->first();
    }
}
