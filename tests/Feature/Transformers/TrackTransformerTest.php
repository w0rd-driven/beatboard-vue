<?php

use App\Transformers\TrackTransformer;
use Illuminate\Support\Arr;

beforeEach(function () {
    $this->transformer = new TrackTransformer();
});

describe("transform", function () {
    beforeEach(function () {
    });

    it('returns normalized', function () {
        $track = [
            "album" => [
                "album_type" => "album",
                "artists" => [
                    [
                        "external_urls" => [
                            "spotify" => "https://open.spotify.com/artist/2yEwvVSSSUkcLeSTNyHKh8",
                        ],
                        "href" => "https://api.spotify.com/v1/artists/2yEwvVSSSUkcLeSTNyHKh8",
                        "id" => "2yEwvVSSSUkcLeSTNyHKh8",
                        "name" => "TOOL",
                        "type" => "artist",
                        "uri" => "spotify:artist:2yEwvVSSSUkcLeSTNyHKh8",
                    ],
                ],
                "external_urls" => [
                    "spotify" => "https://open.spotify.com/album/5l5m1hnH4punS1GQXgEi3T",
                ],
                "href" => "https://api.spotify.com/v1/albums/5l5m1hnH4punS1GQXgEi3T",
                "id" => "5l5m1hnH4punS1GQXgEi3T",
                "images" => [
                    [
                        "height" => 640,
                        "url" => "https://i.scdn.co/image/ab67616d0000b273ca41a947c13b78749c4953b1",
                        "width" => 640,
                    ],
                    [
                        "height" => 300,
                        "url" => "https://i.scdn.co/image/ab67616d00001e02ca41a947c13b78749c4953b1",
                        "width" => 300,
                    ],
                    [
                        "height" => 64,
                        "url" => "https://i.scdn.co/image/ab67616d00004851ca41a947c13b78749c4953b1",
                        "width" => 64,
                    ],
                ],
                "is_playable" => true,
                "name" => "Lateralus",
                "release_date" => "2001-05-15",
                "release_date_precision" => "day",
                "total_tracks" => 13,
                "type" => "album",
                "uri" => "spotify:album:5l5m1hnH4punS1GQXgEi3T",
            ],
            "artists" => [
                [
                    "external_urls" => [
                        "spotify" => "https://open.spotify.com/artist/2yEwvVSSSUkcLeSTNyHKh8",
                    ],
                    "href" => "https://api.spotify.com/v1/artists/2yEwvVSSSUkcLeSTNyHKh8",
                    "id" => "2yEwvVSSSUkcLeSTNyHKh8",
                    "name" => "TOOL",
                    "type" => "artist",
                    "uri" => "spotify:artist:2yEwvVSSSUkcLeSTNyHKh8",
                ],
            ],
            "disc_number" => 1,
            "duration_ms" => 403533,
            "explicit" => false,
            "external_ids" => [
                "isrc" => "USVR10100013",
            ],
            "external_urls" => [
                "spotify" => "https://open.spotify.com/track/55mJleti2WfWEFNFcBduhc",
            ],
            "href" => "https://api.spotify.com/v1/tracks/55mJleti2WfWEFNFcBduhc",
            "id" => "55mJleti2WfWEFNFcBduhc",
            "is_local" => false,
            "is_playable" => true,
            "name" => "Schism",
            "popularity" => 73,
            "preview_url" => "https://p.scdn.co/mp3-preview/3c0d4ba93e1e771ef66c3a4326eac2dcb9e3244d?cid=5849e6b5539440e89266733067eb041a",
            "track_number" => 5,
            "type" => "track",
            "uri" => "spotify:track:55mJleti2WfWEFNFcBduhc",
        ];

        $expectedImage = $this->transformer->largestImage($track);
        $attributes = $this->transformer->transform($track);
        expect(Arr::get($attributes, 'spotify_id'))->toBe(Arr::get($track, 'id'));
        expect(Arr::get($attributes, 'album_spotify_id'))->toBe(Arr::get($track, 'album.id'));
        expect(Arr::get($attributes, 'album_name'))->toBe(Arr::get($track, 'album.name'));
        expect(Arr::get($attributes, 'album_image_url'))->toBe(Arr::get($expectedImage, 'url'));
        expect(Arr::get($attributes, 'album_release_date'))->toBe(Arr::get($track, 'album.release_date'));
        expect(Arr::get($attributes, 'album_total_tracks'))->toBe(Arr::get($track, 'album.total_tracks'));
        expect(Arr::get($attributes, 'name'))->toBe(Arr::get($track, 'name'));
        expect(Arr::get($attributes, 'popularity'))->toBe(Arr::get($track, 'popularity'));
        expect(Arr::get($attributes, 'duration_ms'))->toBe(Arr::get($track, 'duration_ms'));
    });

    it('returns empty', function () {
        $track = [];

        $expectedImage = $this->transformer->largestImage($track);
        $attributes = $this->transformer->transform($track);
        expect(Arr::get($attributes, 'spotify_id'))->toBe(Arr::get($track, 'id'));
        expect(Arr::get($attributes, 'name'))->toBe(Arr::get($track, 'name'));
        expect(Arr::get($attributes, 'image_url'))->toBe(Arr::get($expectedImage, 'url'));
        expect(Arr::get($attributes, 'follower_count'))->toBe(Arr::get($track, 'followers.total'));
    });
});

describe("largestImage", function () {
    beforeEach(function () {
    });

    it('returns the largest image', function () {
        $track = [
            "album" => [
                "album_type" => "album",
                "artists" => [
                    [
                        "external_urls" => [
                            "spotify" => "https://open.spotify.com/artist/2yEwvVSSSUkcLeSTNyHKh8",
                        ],
                        "href" => "https://api.spotify.com/v1/artists/2yEwvVSSSUkcLeSTNyHKh8",
                        "id" => "2yEwvVSSSUkcLeSTNyHKh8",
                        "name" => "TOOL",
                        "type" => "artist",
                        "uri" => "spotify:artist:2yEwvVSSSUkcLeSTNyHKh8",
                    ],
                ],
                "external_urls" => [
                    "spotify" => "https://open.spotify.com/album/5l5m1hnH4punS1GQXgEi3T",
                ],
                "href" => "https://api.spotify.com/v1/albums/5l5m1hnH4punS1GQXgEi3T",
                "id" => "5l5m1hnH4punS1GQXgEi3T",
                "images" => [
                    [
                        "height" => 640,
                        "url" => "https://i.scdn.co/image/ab67616d0000b273ca41a947c13b78749c4953b1",
                        "width" => 640,
                    ],
                    [
                        "height" => 300,
                        "url" => "https://i.scdn.co/image/ab67616d00001e02ca41a947c13b78749c4953b1",
                        "width" => 300,
                    ],
                    [
                        "height" => 64,
                        "url" => "https://i.scdn.co/image/ab67616d00004851ca41a947c13b78749c4953b1",
                        "width" => 64,
                    ],
                ],
                "is_playable" => true,
                "name" => "Lateralus",
                "release_date" => "2001-05-15",
                "release_date_precision" => "day",
                "total_tracks" => 13,
                "type" => "album",
                "uri" => "spotify:album:5l5m1hnH4punS1GQXgEi3T",
            ],
            "artists" => [
                [
                    "external_urls" => [
                    "spotify" => "https://open.spotify.com/artist/2yEwvVSSSUkcLeSTNyHKh8",
                    ],
                    "href" => "https://api.spotify.com/v1/artists/2yEwvVSSSUkcLeSTNyHKh8",
                    "id" => "2yEwvVSSSUkcLeSTNyHKh8",
                    "name" => "TOOL",
                    "type" => "artist",
                    "uri" => "spotify:artist:2yEwvVSSSUkcLeSTNyHKh8",
                ],
            ],
            "disc_number" => 1,
            "duration_ms" => 403533,
            "explicit" => false,
            "external_ids" => [
                "isrc" => "USVR10100013",
            ],
            "external_urls" => [
                "spotify" => "https://open.spotify.com/track/55mJleti2WfWEFNFcBduhc",
            ],
            "href" => "https://api.spotify.com/v1/tracks/55mJleti2WfWEFNFcBduhc",
            "id" => "55mJleti2WfWEFNFcBduhc",
            "is_local" => false,
            "is_playable" => true,
            "name" => "Schism",
            "popularity" => 73,
            "preview_url" => "https://p.scdn.co/mp3-preview/3c0d4ba93e1e771ef66c3a4326eac2dcb9e3244d?cid=5849e6b5539440e89266733067eb041a",
            "track_number" => 5,
            "type" => "track",
            "uri" => "spotify:track:55mJleti2WfWEFNFcBduhc",
        ];

        $expected = 640;
        $largestImage = $this->transformer->largestImage($track);
        expect(Arr::get($largestImage, 'width'))->toBe($expected);
    });

    it('returns empty', function () {
        $track = [];

        $expected = null;
        $largestImage = $this->transformer->largestImage($track);
        expect(Arr::get($largestImage, 'width'))->toBe($expected);
    });
});
