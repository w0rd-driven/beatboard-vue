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
                "spotify" => "https://open.spotify.com/artist/2yEwvVSSSUkcLeSTNyHKh8",
            ],
            "followers" => [
                "href" => null,
                "total" => 3462577,
            ],
            "genres" => [
                "alternative metal",
                "art rock",
                "nu metal",
                "post-grunge",
                "progressive metal",
                "progressive rock",
                "rock",
            ],
            "href" => "https://api.spotify.com/v1/artists/2yEwvVSSSUkcLeSTNyHKh8",
            "id" => "2yEwvVSSSUkcLeSTNyHKh8",
            "images" => [
                [
                    "height" => 640,
                    "url" => "https://i.scdn.co/image/ab6761610000e5eb13f5472b709101616c87cba3",
                    "width" => 640,
                ],
                [
                    "height" => 320,
                    "url" => "https://i.scdn.co/image/ab6761610000517413f5472b709101616c87cba3",
                    "width" => 320,
                ],
                [
                    "height" => 160,
                    "url" => "https://i.scdn.co/image/ab6761610000f17813f5472b709101616c87cba3",
                    "width" => 160,
                ],
            ],
            "name" => "TOOL",
            "popularity" => 69,
            "type" => "artist",
            "uri" => "spotify:artist:2yEwvVSSSUkcLeSTNyHKh8",
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
                "spotify" => "https://open.spotify.com/artist/2yEwvVSSSUkcLeSTNyHKh8",
            ],
            "followers" => [
                "href" => null,
                "total" => 3462577,
            ],
            "genres" => [
                "alternative metal",
                "art rock",
                "nu metal",
                "post-grunge",
                "progressive metal",
                "progressive rock",
                "rock",
            ],
            "href" => "https://api.spotify.com/v1/artists/2yEwvVSSSUkcLeSTNyHKh8",
            "id" => "2yEwvVSSSUkcLeSTNyHKh8",
            "images" => [
                [
                    "height" => 640,
                    "url" => "https://i.scdn.co/image/ab6761610000e5eb13f5472b709101616c87cba3",
                    "width" => 640,
                ],
                [
                    "height" => 320,
                    "url" => "https://i.scdn.co/image/ab6761610000517413f5472b709101616c87cba3",
                    "width" => 320,
                ],
                [
                    "height" => 160,
                    "url" => "https://i.scdn.co/image/ab6761610000f17813f5472b709101616c87cba3",
                    "width" => 160,
                ],
            ],
            "name" => "TOOL",
            "popularity" => 69,
            "type" => "artist",
            "uri" => "spotify:artist:2yEwvVSSSUkcLeSTNyHKh8",
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
