<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Details</title>
</head>
<body>
    <h1>Study Details</h1>
    <p><strong>Study Description:</strong> {{ $study['StudyDescription'] ?? 'No description available' }}</p>
    <p><strong>Study ID:</strong> {{ $study['ID'] }}</p>

    <h2>Series</h2>
    <ul>
        @foreach($study['Series'] as $series)
            <li>{{ $series['SeriesDescription'] ?? 'No description' }}</li>
        @endforeach
    </ul>
</body>
</html>
