@extends('layouts.admin')

@section('content')
    <h1>映画管理一覧</h1>
    <a href="{{ route('admin.movies.create') }}">映画作品を登録する</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>映画タイトル</th>
                <th>画像URL</th>
                <th>公開年</th>
                <th>上映中かどうか</th>
                <th>概要</th>
                <th>ジャンル</th>
                <th>操作</th>
                <th>登録日時</th>
                <th>更新日時</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr>
                    <td>{{ $movie->id }}</td>
                    <td>{{ $movie->title }}</td>
                    <td><img src="{{ $movie->image_url }}" alt="映画サムネイル" width="150"></td>
                    <td>{{ $movie->published_year }}</td>
                    <td>{{ $movie->is_showing ? '上映中' : '上映予定' }}</td>
                    <td>{{ $movie->description }}</td>
                    <td>{{ $movie->genre->name ?? '' }}</td>
                    <td>
                        <a href="{{ route('admin.movies.edit', $movie) }}">編集</a>
                        <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">削除</button>
                        </form>
                    </td>
                    <td>{{ $movie->created_at }}</td>
                    <td>{{ $movie->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection