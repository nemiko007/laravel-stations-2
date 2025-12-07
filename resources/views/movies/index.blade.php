@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>映画作品一覧</h1>

        <form action="{{ route('movies.index') }}" method="GET" class="form-inline mb-3">
            <div class="form-group mr-2">
                <label for="keyword" class="mr-2">キーワード</label>
                <input type="text" name="keyword" id="keyword" class="form-control" value="{{ request('keyword') }}">
            </div>
            <div class="form-group mr-2">
                <label for="is_showing" class="mr-2">上映中かどうか</label>
                <select name="is_showing" id="is_showing" class="form-control">
                    <option value="">すべて</option>
                    <option value="1" {{ request('is_showing') === '1' ? 'selected' : '' }}>上映中</option>
                    <option value="0" {{ request('is_showing') === '0' ? 'selected' : '' }}>上映予定</option>
                </select>
            </div>
            <div class="form-group mr-2">
                <label for="genre_id" class="mr-2">ジャンル</label>
                <select name="genre_id" id="genre_id" class="form-control">
                    <option value="">すべて</option>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}" {{ request('genre_id') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">検索</button>
        </form>

        <div class="row">
            @foreach ($movies as $movie)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="{{ $movie->image_url }}" class="card-img-top" alt="{{ $movie->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $movie->title }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $movies->appends(request()->query())->links() }}
        </div>
    </div>
@endsection