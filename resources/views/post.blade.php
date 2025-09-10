<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
</head>
<body>
    <h1>Create a New Post</h1>

    <form action="{{ route('post.save') }}" method="post">
        @csrf
        <label for="title">Title:</label>
        <input type="text" id="title" name="title">

        <label for="author">Author:</label>
        <input type="text" id="author" name="author">

        <button type="submit">Create Post</button>
    </form>

    <!-- Include Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Your app.js or bootstrap.js script -->
    <script src="{{ asset('/build/assets/app.39aecc54.js') }}"></script>
</body>
</html>