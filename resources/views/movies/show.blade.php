<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie Detail</title>
</head>
<body>
    <h1>{{ $movie->title }}</h1>
    <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}">
    <p>公開年: {{ $movie->published_year }}</p>
    <p>上映状況: {{ $movie->is_showing ? '上映中' : '上映予定' }}</p>
    <p>概要: {{ $movie->description }}</p>
    <p>ジャンル: {{ $movie->genre->name }}</p>
    <p>登録日時: {{ $movie->created_at }}</p>
    <p>更新日時: {{ $movie->updated_at }}</p>
    
    <h2>上映スケジュール</h2>
    <ul>
        @foreach ($schedules as $schedule)
            <li>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</li>
        @endforeach
    </ul>
</body>
</html>