@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>映画編集</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="title">タイトル</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $movie->title) }}">
            </div>
            <div class="form-group">
                <label for="image_url">画像URL</label>
                <input type="text" name="image_url" id="image_url" class="form-control" value="{{ old('image_url', $movie->image_url) }}">
            </div>
            <div class="form-group">
                <label for="published_year">公開年</label>
                <input type="number" name="published_year" id="published_year" class="form-control" value="{{ old('published_year', $movie->published_year) }}">
            </div>
            <div class="form-group">
                <label for="is_showing">上映中かどうか</label>
                <select name="is_showing" id="is_showing" class="form-control">
                    <option value="1" {{ old('is_showing', $movie->is_showing) == 1 ? 'selected' : '' }}>上映中</option>
                    <option value="0" {{ old('is_showing', $movie->is_showing) == 0 ? 'selected' : '' }}>上映予定</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">概要</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $movie->description) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">更新</button>
            <div class="form-group">
                <label for="genre">ジャンル</label>
                <input type="text" id="genre" name="genre" value="{{ old('genre', $movie->genre->name ?? '') }}" list="genres" class="form-control">
                <datalist id="genres">
                    @foreach($genres as $genre)
                        <option value="{{ $genre->name }}"></option>
                    @endforeach
                </datalist>
            </div>
        </form>
    </div>
@endsection