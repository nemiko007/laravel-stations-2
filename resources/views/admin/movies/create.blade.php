@extends('layouts.admin')

@section('content')
    <h1>映画作品登録</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.movies.store') }}" method="POST">
        @csrf
        <div>
            <label for="title">映画タイトル</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}">
        </div>
        <br>
        <div>
            <label for="image_url">画像URL</label>
            <input type="text" id="image_url" name="image_url" value="{{ old('image_url') }}">
        </div>
        <br>
        <div>
            <label for="published_year">公開年</label>
            <input type="number" id="published_year" name="published_year" value="{{ old('published_year') }}">
        </div>
        <br>
        <div>
            <label for="description">概要</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
        </div>
        <br>
        <div>
            <label for="genre">ジャンル</label>
            <input type="text" id="genre" name="genre" value="{{ old('genre') }}" list="genres">
            <datalist id="genres">
                @foreach($genres as $genre)
                    <option value="{{ $genre->name }}"></option>
                @endforeach
            </datalist>
        </div>
        <br>
        <div>
            <label for="is_showing">上映中かどうか</label>
            <input type="hidden" name="is_showing" value="0">
            <input type="checkbox" id="is_showing" name="is_showing" value="1" {{ old('is_showing') ? 'checked' : '' }}>
        </div>
        <br>
        <button type="submit">登録</button>
    </form>
@endsection