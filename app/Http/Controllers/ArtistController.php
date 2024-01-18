<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Artist/Index', [
            'artists' => Artist::orderBy('name')->get(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Artist $artist)
    {
        return Inertia::render('Artist/Show', [
            'artist' => $artist->load('tracks'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artist $artist)
    {
        $artist->delete();

        return Redirect::back()->with('success', 'Artist deleted.');
    }
}
