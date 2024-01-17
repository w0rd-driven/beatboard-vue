<?php

namespace App\Transformers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class ArtistTransformer
{
    public function __construct()
    {
    }

    public function transform(?array $artist): array
    {
        $name = Arr::get($artist, 'name');
        Log::channel('search')->debug("ArtistTransformer: Transforming artist {$name}");

        $largestImage = $this->largestImage($artist);
        $imageUrl = Arr::get($largestImage, 'url');
        $imageWidth = Arr::get($largestImage, 'width');

        Log::channel('search')->debug("ArtistTransformer: Largest image width {$imageWidth}");

        return [
            'spotify_id' => Arr::get($artist, 'id'),
            'name' => $name,
            'image_url' => $imageUrl,
            'follower_count' => Arr::get($artist, 'followers.total'),
            'searched_at' => CarbonImmutable::now(),
        ];
    }

    public function largestImage(?array $artist): ?array
    {
        $images = collect(Arr::get($artist, 'images', []));
        return $images?->sortByDesc('width')?->first();
    }
}
