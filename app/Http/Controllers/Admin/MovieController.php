<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Http\Requests\Admin\MovieRequest;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function index(): View
    {
        $movies = Movie::with('genre')->latest('id')->get();
        return view('admin.movies.index', ['movies' => $movies]);
    }

    public function create(): View
    {
        $genres = Genre::all();
        return view('admin.movies.create', compact('genres'));
    }

    public function store(MovieRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            if (!$request->has('is_showing')) {
                $request->merge(['is_showing' => false]);
            }
            $validated = $request->validated();
            $genre = Genre::firstOrCreate(['name' => $validated['genre']]);
            $movieData = array_merge($validated, ['genre_id' => $genre->id]);
            unset($movieData['genre']);
            Movie::create($movieData);
        });

        return redirect()->route('admin.movies.index');
    }

    public function edit(Movie $movie): View
    {
        $movie->load('genre');
        $genres = Genre::all();
        return view('admin.movies.edit', [
            'movie' => $movie,
            'genres' => $genres,
        ]);
    }

    public function update(MovieRequest $request, Movie $movie): RedirectResponse
    {
        DB::transaction(function () use ($request, $movie) {
            if (!$request->has('is_showing')) {
                $request->merge(['is_showing' => false]);
            }
            $validated = $request->validated();
            $genre = Genre::firstOrCreate(['name' => $validated['genre']]);
            $movieData = array_merge($validated, ['genre_id' => $genre->id]);
            unset($movieData['genre']);
            $movie->update($movieData);
        });

        return redirect()->route('admin.movies.index');
    }

    public function destroy(Movie $movie): RedirectResponse
    {
        $movie->delete();

        return redirect()->route('admin.movies.index');
    }
}