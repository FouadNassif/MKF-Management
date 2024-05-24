<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield("head")
    @vite('resources/css/app.css')
    <title>@yield('title')</title>
    <link href='https://fonts.googleapis.com/css?family=Jockey One' rel='stylesheet'>
    <style>

    </style>
</head>

<body>
    @if (session('status'))
        <div id="notification"
            class="notification bg-white p-5 border-4 border-primary shadow-lg flex items-center justify-between">
            <h1>{{ session('status') }}</h1>
            <button onclick="closeNotification()">X</button>
            <div class="progress-bar"></div>
        </div>
    @endif

    @yield('content')
    @yield('scripts')
    <script src="{{ asset('assets/js/layout.js') }}"></script>
</body>
</html>
