<?php

use App\Transformers\ArtistTransformer;
use Illuminate\Support\Arr;

beforeEach(function () {
    $this->transformer = new ArtistTransformer();
});

describe("transform", function () {
    beforeEach(function () {
    });

    it('returns normalized', function () {
        $artist = [
            "external_urls" => [
                "spotify" => "https://open.spotify.com/artist/6zreklnHnGi9Zfr2WhaO5a",
            ],
            "followers" => [
                "href" => null,
                "total" => 182636,
            ],
            "genres" => [],
            "href" => "https://api.spotify.com/v1/artists/6zreklnHnGi9Zfr2WhaO5a",
            "id" => "6zreklnHnGi9Zfr2WhaO5a",
            "images" => [
                [
                    "height" => 640,
                    "url" => "https://i.scdn.co/image/ab67616d0000b273d57727511e6036d977b2f4dc",
                    "width" => 640,
                ],
                [
                    "height" => 300,
                    "url" => "https://i.scdn.co/image/ab67616d00001e02d57727511e6036d977b2f4dc",
                    "width" => 300,
                ],
                [
                    "height" => 64,
                    "url" => "https://i.scdn.co/image/ab67616d00004851d57727511e6036d977b2f4dc",
                    "width" => 64,
                ],
            ],
            "name" => "Tool",
            "popularity" => 3,
            "type" => "artist",
            "uri" => "spotify:artist:6zreklnHnGi9Zfr2WhaO5a",
        ];

        $expectedImage = $this->transformer->largestImage($artist);
        $attributes = $this->transformer->transform($artist);
        expect(Arr::get($attributes, 'spotify_id'))->toBe(Arr::get($artist, 'id'));
        expect(Arr::get($attributes, 'name'))->toBe(Arr::get($artist, 'name'));
        expect(Arr::get($attributes, 'image_url'))->toBe(Arr::get($expectedImage, 'url'));
        expect(Arr::get($attributes, 'follower_count'))->toBe(Arr::get($artist, 'followers.total'));
    });

    it('returns empty', function () {
        $artist = [];

        $expectedImage = $this->transformer->largestImage($artist);
        $attributes = $this->transformer->transform($artist);
        expect(Arr::get($attributes, 'spotify_id'))->toBe(Arr::get($artist, 'id'));
        expect(Arr::get($attributes, 'name'))->toBe(Arr::get($artist, 'name'));
        expect(Arr::get($attributes, 'image_url'))->toBe(Arr::get($expectedImage, 'url'));
        expect(Arr::get($attributes, 'follower_count'))->toBe(Arr::get($artist, 'followers.total'));
    });
});

describe("largestImage", function () {
    beforeEach(function () {
    });

    it('returns the largest image', function () {
        $artist = [
            "external_urls" => [
                "spotify" => "https://open.spotify.com/artist/6zreklnHnGi9Zfr2WhaO5a",
            ],
            "followers" => [
                "href" => null,
                "total" => 182636,
            ],
            "genres" => [],
            "href" => "https://api.spotify.com/v1/artists/6zreklnHnGi9Zfr2WhaO5a",
            "id" => "6zreklnHnGi9Zfr2WhaO5a",
            "images" => [
                [
                    "height" => 640,
                    "url" => "https://i.scdn.co/image/ab67616d0000b273d57727511e6036d977b2f4dc",
                    "width" => 640,
                ],
                [
                    "height" => 300,
                    "url" => "https://i.scdn.co/image/ab67616d00001e02d57727511e6036d977b2f4dc",
                    "width" => 300,
                ],
                [
                    "height" => 64,
                    "url" => "https://i.scdn.co/image/ab67616d00004851d57727511e6036d977b2f4dc",
                    "width" => 64,
                ],
            ],
            "name" => "Tool",
            "popularity" => 3,
            "type" => "artist",
            "uri" => "spotify:artist:6zreklnHnGi9Zfr2WhaO5a",
        ];

        $expected = 640;
        $largestImage = $this->transformer->largestImage($artist);
        expect(Arr::get($largestImage, 'width'))->toBe($expected);
    });

    it('returns empty', function () {
        $artist = [];

        $expected = null;
        $largestImage = $this->transformer->largestImage($artist);
        expect(Arr::get($largestImage, 'width'))->toBe($expected);
    });
});
