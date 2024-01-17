<?php

use Aerni\Spotify\SpotifyRequest;
use App\Models\Artist;
use App\Repositories\ArtistRepository;
use Mockery\MockInterface;

beforeEach(function () {
    $this->repository = new ArtistRepository();
});

describe("searchArtists", function () {
    beforeEach(function () {
    });

    it('returns a list of artists', function () {
        $query = "TOOL";
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

        $mock = $this->mock(SpotifyRequest::class, function (MockInterface $mock) use ($artist) {
            $mock->shouldReceive('get')->once()->andReturn([
                "artists" => [
                    "items" => [
                        $artist,
                    ],
                ],
            ]);
        });

        $artist = $this->repository->searchArtists($query);

        expect(Arr::get($artist, 'id'))->toBe("2yEwvVSSSUkcLeSTNyHKh8");
        expect(Arr::get($artist, 'name'))->toBe("TOOL");
        expect(Arr::get($artist, 'followers.total'))->toBe(3462577);
    });

    it('returns empty', function () {
        $query = "";
        $artist = [];

        $mock = $this->mock(SpotifyRequest::class, function (MockInterface $mock) use ($artist) {
            $mock->shouldReceive('get')->once()->andReturn([
                "artists" => [
                    "items" => [
                        $artist,
                    ],
                ],
            ]);
        });

        $artist = $this->repository->searchArtists($query);

        expect(Arr::get($artist, 'id'))->toBe(null);
        expect(Arr::get($artist, 'name'))->toBe(null);
        expect(Arr::get($artist, 'followers.total'))->toBe(null);
    });
});

describe("getTopTracks", function () {
    beforeEach(function () {
    });

    it('returns a list of top tracks', function () {
        $artist = Artist::factory()->create();

        $tracks = [
            [
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
            ],
        ];


        $mock = $this->mock(SpotifyRequest::class, function (MockInterface $mock) use ($tracks) {
            $mock->shouldReceive('get')->once()->andReturn([
                "tracks" => $tracks,
            ]);
        });

        $tracks = $this->repository->getTopTracks($artist);
        $track = collect($tracks)->first();

        expect(Arr::get($track, 'id'))->toBe("55mJleti2WfWEFNFcBduhc");
        expect(Arr::get($track, 'album.id'))->toBe("5l5m1hnH4punS1GQXgEi3T");
        expect(Arr::get($track, 'album.name'))->toBe("Lateralus");
        expect(Arr::get($track, 'album.release_date'))->toBe("2001-05-15");
        expect(Arr::get($track, 'album.total_tracks'))->toBe(13);
        expect(Arr::get($track, 'name'))->toBe("Schism");
        expect(Arr::get($track, 'popularity'))->toBe(73);
        expect(Arr::get($track, 'duration_ms'))->toBe(403533);
    });

    it('returns empty', function () {
        $artist = Artist::factory()->create();
        $tracks = [];

        $mock = $this->mock(SpotifyRequest::class, function (MockInterface $mock) use ($tracks) {
            $mock->shouldReceive('get')->once()->andReturn([
                "tracks" => $tracks,
            ]);
        });

        $tracks = $this->repository->getTopTracks($artist);
        $track = collect($tracks)?->first();

        expect(Arr::get($track, 'id'))->toBe(null);
        expect(Arr::get($track, 'album.id'))->toBe(null);
        expect(Arr::get($track, 'album.name'))->toBe(null);
        expect(Arr::get($track, 'album.release_date'))->toBe(null);
        expect(Arr::get($track, 'album.total_tracks'))->toBe(null);
        expect(Arr::get($track, 'name'))->toBe(null);
        expect(Arr::get($track, 'popularity'))->toBe(null);
        expect(Arr::get($track, 'duration_ms'))->toBe(null);
    });
});
