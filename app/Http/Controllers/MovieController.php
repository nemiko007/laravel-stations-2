<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::query();

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('is_showing')) {
            $query->where('is_showing', $request->input('is_showing'));
        }

        $movies = $query->paginate(20);
        return view('movies.index', ['movies' => $movies]);
    }

    public function admin()
    {
        $movies = Movie::all();
        return view('admin.movies.index', ['movies' => $movies]);
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|unique:movies,title',
            'image_url' => 'required|url',
            'published_year' => 'required|integer',
            'description' => 'required',
            'is_showing' => 'required|boolean',
            'genre' => 'required',
        ]);

        DB::transaction(function () use ($data) {
            $genre = Genre::firstOrCreate(['name' => $data['genre']]);
            $data['genre_id'] = $genre->id;
            Movie::create($data);
        });

        return redirect('/admin/movies');
    }

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movies.edit', ['movie' => $movie]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|unique:movies,title,' . $id,
            'image_url' => 'required|url',
            'published_year' => 'required|integer',
            'description' => 'required',
            'is_showing' => 'required|boolean',
            'genre' => 'required',
        ]);

        DB::transaction(function () use ($data, $id) {
            $genre = Genre::firstOrCreate(['name' => $data['genre']]);
            $movie = Movie::findOrFail($id);
            $data['genre_id'] = $genre->id;
            $movie->update($data);
        });
        return redirect('/admin/movies');
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();
        return redirect('/admin/movies')->with('flash_message', '削除が完了しました');
    }
}