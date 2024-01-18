<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArtistSearchRequest;
use App\Repositories\ArtistRepository;
use App\Transformers\ArtistTransformer;
use App\Transformers\TrackTransformer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ArtistSearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ArtistSearchRequest $request): RedirectResponse
    {
        $repository = new ArtistRepository();
        $artist = $repository->saveArtist($request->search_text, new ArtistTransformer);
        $repository->saveTopTracks($artist, new TrackTransformer);

        return Redirect::back()->with('success', 'Artist found.');
    }
}
