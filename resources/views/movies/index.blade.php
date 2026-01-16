<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie List</title>
</head>
<body>
    <form method="GET" action="/movies">
        <input type="text" name="keyword" value="{{ request('keyword') }}">
        <label><input type="radio" name="is_showing" value="" {{ is_null(request('is_showing')) || request('is_showing') === '' ? 'checked' : '' }}>すべて</label>
        <label><input type="radio" name="is_showing" value="0" {{ request('is_showing') === '0' ? 'checked' : '' }}>公開予定</label>
        <label><input type="radio" name="is_showing" value="1" {{ request('is_showing') === '1' ? 'checked' : '' }}>公開中</label>
        <button type="submit">検索</button>
    </form>

    <ul>
    @foreach ($movies as $movie)
        <li>タイトル: {{ $movie->title }}</li>
        <li><img src="{{ $movie->image_url }}" alt="{{ $movie->title }}"></li>
    @endforeach
    </ul>
    {{ $movies->appends(request()->query())->links() }}
</body>
</html>