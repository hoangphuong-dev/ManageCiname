<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    @isset($isSsl)
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endisset

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ '/css/app.css' }}">

    <!-- Scripts -->
    @routes
    <script src="{{ '/js/app.js' }}"></script>

</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>