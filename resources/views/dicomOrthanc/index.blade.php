<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dicom Studies</title>
</head>
<body>
    <h1>Dicom Studies</h1>
    <ul>
        @foreach($studies as $study)
            <li>
                <a href="{{ url('/dicom/study/'.$study['ID']) }}">
                    {{ $study['StudyDescription'] ?? 'No description available' }}
                </a>
            </li>
        @endforeach
    </ul>
</body>
</html>
