<?php

use Aerni\Spotify\SpotifyRequest;
use App\Repositories\ArtistRepository;
use Mockery\MockInterface;

beforeEach(function () {
    $this->repository = new ArtistRepository();
});

describe("searchArtists", function () {
    beforeEach(function () {
    });

    it('returns a list of artists', function () {
        $query = "Tool";
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

        expect(Arr::get($artist, 'id'))->toBe("6zreklnHnGi9Zfr2WhaO5a");
        expect(Arr::get($artist, 'name'))->toBe("Tool");
        expect(Arr::get($artist, 'followers.total'))->toBe(182636);
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
