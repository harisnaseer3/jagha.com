<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Support ChatBot</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Load BotMan Web Widget --}}
    <script>
        var botmanWidget = {
            aboutText: 'Support Assistant',
            introMessage: "✋ Hi! Type <b>start</b> to begin.",
            title: 'ChatBot',
            placeholderText: 'Type a message...',
            mainColor: '#187c3c',
            bubbleBackground: '#187c3c',
            userId: "{{ uniqid() }}", // Optional unique ID for session
            // frameEndpoint: '/botman/tinker', // Optional: iframe version
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js"></script>
</head>
<body>

{{-- Page content can go here --}}
<h1>Welcome to Our Website</h1>
<p>Need help? Click the green chat bubble in the bottom-right corner.</p>

</body>
</html>
