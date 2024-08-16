<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body>
<p>{{ $description }}</p>

<form action="{{ route('Accept.service', ['requestId' => $id]) }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;">Confirm</button>
</form>
</body>
</html>

