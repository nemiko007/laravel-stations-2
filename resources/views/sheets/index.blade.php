<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Seat Map</title>
</head>
<body>
    <div style="text-align: center;">スクリーン</div>
    <table border="1" style="margin: 0 auto; text-align: center;">
        @foreach ($sheets->groupBy('row') as $row => $rowSheets)
            <tr>
                @foreach ($rowSheets as $sheet)
                    <td style="padding: 10px;">{{ $sheet->row }}-{{ $sheet->column }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
</body>
</html>