<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArtistSearchRequest;
use App\Models\Artist;
use App\Repositories\ArtistRepository;
use App\Transformers\ArtistTransformer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class ArtistSearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ArtistSearchRequest $request): RedirectResponse
    {
        Log::channel('search')->debug("ArtistSearchController: Searching {$request->search_text}");

        $response = (new ArtistRepository)->searchArtists($request->search_text);
        $attributes = (new ArtistTransformer)->transform($response);

        $artist = Artist::updateOrCreate(
            ['spotify_id' => Arr::get($attributes, 'spotify_id')],
            $attributes,
        );

        Log::channel('search')->debug("ArtistSearchController: Artist {$artist?->spotify_id} saved.");

        return Redirect::back()->with('success', 'Artist found.');
    }
}
