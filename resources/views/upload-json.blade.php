<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload JSON</title>
</head>
<body>
<h1>Upload JSON File</h1>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if($errors->any())
    <ul style="color: red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('json.upload.process') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="json_file">Select JSON File:</label>
    <input type="file" name="json_file" id="json_file" required>
    <button type="submit">Upload and Insert</button>
</form>
</body>
</html>
