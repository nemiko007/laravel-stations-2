<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie as ModelsMovie;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = Movie::query();

        $keyword = $request->input('keyword');
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->has('is_showing') && $request->input('is_showing') !== null) {
            $query->where('is_showing', $request->input('is_showing'));
        }

        $movies = $query->paginate(20);
        $genres = Genre::all();

        return view('movies.index', compact('movies', 'keyword', 'genres'));
    }

    /**
     * @param ModelsMovie $movie
     * @return View
     */
    public function show(Movie $movie): View
    {
        $movie->load(['schedules' => fn($query) => $query->orderBy('start_time')]);
        return view('movies.show', compact('movie'));
    }
}