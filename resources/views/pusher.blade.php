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
    <script src="{{ asset('/build/assets/app-BX0Wc3vv.js') }}"></script>






    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>
<script type="module">
    import Echo from "{{ asset('/build/assets/app.js') }}"; 
    // or use resources/js/bootstrap.js depending on how you compiled

    // If you didn’t bundle Echo in app.js, you can set it up here instead:
    window.Pusher = Pusher;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: "{{ env('VITE_PUSHER_APP_KEY') }}",
        cluster: "{{ env('VITE_PUSHER_APP_CLUSTER') }}",
        wsHost: "{{ env('VITE_PUSHER_HOST') ?: 'ws-' . env('VITE_PUSHER_APP_CLUSTER') . '.pusher.com' }}",
        wsPort: "{{ env('VITE_PUSHER_PORT', 443) }}",
        wssPort: "{{ env('VITE_PUSHER_PORT', 443) }}",
        forceTLS: "{{ env('VITE_PUSHER_SCHEME') }}" === 'https',
        enabledTransports: ['ws', 'wss'],
    });

    // Subscribe to your channel/event
    window.Echo.channel('my-channel')
        .listen('.form-submitted', (e) => {
            console.log('Realtime event:', e);

            // Toastr popup
            toastr.success(e.message ?? 'Form submitted!');

            // Play sound
            const audio = document.getElementById('notificationAudio');
            audio.currentTime = 0; // rewind
            audio.play().catch(err => {
                console.warn('Autoplay blocked, require user gesture first', err);
            });
        });
</script>

</body>
</html>