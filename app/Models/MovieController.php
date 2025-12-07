<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:movies,title',
            'image_url' => 'required|url',
            'published_year' => 'required|integer|min:1888', // 映画の歴史を考慮
            'description' => 'required|string',
            'is_showing' => 'required|boolean',
        ]);

        try {
            Movie::create([
                'title' => $validated['title'],
                'image_url' => $validated['image_url'],
                'published_year' => $validated['published_year'],
                'description' => $validated['description'],
                'is_showing' => $validated['is_showing'],
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.movies.create')
                ->with('error', '映画の登録中にエラーが発生しました。');
        }


        return redirect()->route('admin.movies.index')
            ->with('success', '映画を登録しました。');
    }
}