<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Images in Public</title>
</head>
<body>
    <h1>Images in /images</h1>
    <ul>
        @foreach ($images as $image)
            <li><a href="{{ asset('images/' . $image->getFilename()) }}" target="_blank">{{ $image->getFilename() }}</a></li>
        @endforeach
    </ul>

    <h1>Images in /partners</h1>
    <ul>
        @foreach ($partners as $partner)
            <li><a href="{{ asset('partners/' . $partner->getFilename()) }}" target="_blank">{{ $partner->getFilename() }}</a></li>
        @endforeach
    </ul>
</body>
</html>
