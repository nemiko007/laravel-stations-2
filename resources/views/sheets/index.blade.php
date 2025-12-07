<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>座席一覧</title>
</head>
<body>
    <h1>座席一覧</h1>
    <ul>
        @foreach ($sheets as $sheet)
            <li>{{ $sheet->row . '-' . $sheet->column }}</li>
        @endforeach
    </ul>
</body>
</html>