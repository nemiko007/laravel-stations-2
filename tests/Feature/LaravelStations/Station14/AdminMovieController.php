<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MovieRequest;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $movies = Movie::all();
        return view('admin.movies.index', ['movies' => $movies]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.movies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $genre = Genre::firstOrCreate(['name' => $request->genre]);

            Movie::create([
                'title' => $request->title,
                'image_url' => $request->image_url,
                'published_year' => $request->published_year,
                'description' => $request->description,
                'is_showing' => $request->is_showing,
                'genre_id' => $genre->id,
            ]);
        });

        return redirect()->route('admin.movies.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie): View
    {
        return view('admin.movies.edit', ['movie' => $movie]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MovieRequest $request, Movie $movie): RedirectResponse
    {
        DB::transaction(function () use ($request, $movie) {
            $genre = Genre::firstOrCreate(['name' => $request->genre]);

            $movie->update([
                'title' => $request->title,
                'image_url' => $request->image_url,
                'published_year' => $request->published_year,
                'description' => $request->description,
                'is_showing' => $request->is_showing,
                'genre_id' => $genre->id,
            ]);
        });

        return redirect()->route('admin.movies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie): RedirectResponse
    {
        $movie->delete();
        return redirect()->route('admin.movies.index');
    }
}