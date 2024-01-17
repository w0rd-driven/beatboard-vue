<?php

namespace App\Repositories;

use App\Models\Artist;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Spotify;

class ArtistRepository
{
    public function __construct()
    {

    }

    public function searchArtists($query): mixed
    {
        Log::channel('search')->debug("ArtistRepository: Searching {$query}");

        $response = Spotify::searchArtists($query)->get();
        $items = collect(Arr::get($response, 'artists.items', []));

        return $items->filter(function ($artist) use ($query) {
            return Arr::get($artist, 'name') === $query && Arr::get($artist, 'type') === 'artist';
        })?->sortByDesc('followers.total')?->first();
    }

    public function getTopTracks(?Artist $artist): mixed
    {
        Log::channel('search')->debug("ArtistRepository: Getting top tracks for {$artist?->name}");

        $response = Spotify::artistTopTracks($artist?->spotify_id)->get();
        $items = collect(Arr::get($response, 'tracks', []));

        return $items->filter(function ($artist) {
            return Arr::get($artist, 'album.album_type') ===  'album';
        });
    }
}
