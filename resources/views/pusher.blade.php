<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-time Chat</title>
        <!-- Include Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    <!-- Hidden audio element -->
    <audio id="notificationAudio" preload="auto">
        <source src="{{ asset('/audio/notifcation.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <button onclick="document.getElementById('notificationAudio').play()">Test Sound</button>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <!-- Include Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    
    <!-- Your app.js or bootstrap.js script -->
    <script src="{{ asset('/build/assets/app.39aecc54.js') }}"></script>
</body>
</html>