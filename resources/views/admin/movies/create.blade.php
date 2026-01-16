<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Create Movie</title>
</head>
<body>
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/admin/movies/store" method="POST">
        @csrf
        <div>
            <label for="title">映画タイトル</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}">
        </div>
        <div>
            <label for="image_url">画像URL</label>
            <input type="text" name="image_url" id="image_url" value="{{ old('image_url') }}">
        </div>
        <div>
            <label for="published_year">公開年</label>
            <input type="number" name="published_year" id="published_year" value="{{ old('published_year') }}">
        </div>
        <div>
            <label for="is_showing">公開中かどうか</label>
            <input type="hidden" name="is_showing" value="0">
            <input type="checkbox" name="is_showing" id="is_showing" value="1" {{ old('is_showing') ? 'checked' : '' }}>
        </div>
        <div>
            <label for="description">概要</label>
            <textarea name="description" id="description">{{ old('description') }}</textarea>
        </div>
        <div>
            <label for="genre">ジャンル</label>
            <input type="text" name="genre" id="genre" value="{{ old('genre') }}">
        </div>
        <button type="submit">登録</button>
    </form>
</body>
</html>