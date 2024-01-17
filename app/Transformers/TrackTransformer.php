<?php

namespace App\Transformers;

use App\Models\Artist;
use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class TrackTransformer
{
    public function __construct()
    {
    }

    public function transform(?Artist $artist, ?array $track): array
    {
        $name = Arr::get($track, 'name');
        Log::channel('search')->debug("TrackTransformer: Transforming track {$name}");

        $largestImage = $this->largestImage($track);
        $imageUrl = Arr::get($largestImage, 'url');
        $imageWidth = Arr::get($largestImage, 'width');

        Log::channel('search')->debug("TrackTransformer: Largest image width {$imageWidth}");

        return [
            'spotify_id' => Arr::get($track, 'id'),
            'album_spotify_id' => Arr::get($track, 'album.id'),
            'album_name' => Arr::get($track, 'album.name'),
            'album_image_url' => $imageUrl,
            'album_release_date' => Arr::get($track, 'album.release_date'),
            'album_total_tracks' => Arr::get($track, 'album.total_tracks'),
            'name' => $name,
            'popularity' => Arr::get($track, 'popularity'),
            'duration_ms' => Arr::get($track, 'duration_ms'),
            'searched_at' => CarbonImmutable::now(),
        ];
    }

    public function largestImage(?array $track): ?array
    {
        $images = collect(Arr::get($track, 'album.images', []));
        return $images?->sortByDesc('width')?->first();
    }
}
