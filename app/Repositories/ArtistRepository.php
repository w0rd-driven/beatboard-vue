<?php

namespace App\Repositories;

use App\Models\Artist;
use App\Transformers\ArtistTransformer;
use App\Transformers\TrackTransformer;
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
            return Arr::get($artist, 'type') === 'artist';
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

    public function saveArtist($query, ArtistTransformer $transformer): mixed
    {
        $response = $this->searchArtists($query);
        $attributes = $transformer->transform($response);
        $spotifyId = Arr::get($attributes, 'spotify_id');
        $artist = null;

        if ($spotifyId) {
            $artist = Artist::updateOrCreate(
                ['spotify_id' => $spotifyId],
                $attributes,
            );
            Log::channel('search')->debug("ArtistRepository: Artist {$artist?->spotify_id} saved.");
        } else {
            Log::channel('search')->debug("ArtistRepository: Artist $query NOT saved.");
        }

        return $artist;
    }

    public function saveTopTracks(?Artist $artist, TrackTransformer $transformer)
    {
        $tracks = $this->getTopTracks($artist);

        foreach ($tracks as $track) {
            $attributes = $transformer->transform($track);
            $spotifyId = Arr::get($attributes, 'spotify_id');
            if ($spotifyId) {
                $track = $artist->tracks()->updateOrCreate(
                    ['spotify_id' => $spotifyId],
                    $attributes,
                );
                Log::channel('search')->debug("ArtistRepository: Track {$track?->spotify_id} saved.");
            } else {
                Log::channel('search')->debug("ArtistRepository: Track NOT saved.");
            }
        }

        return $artist;
    }
}
