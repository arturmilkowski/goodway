<!doctype html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Good Way' }}</title>
        {{-- @vite('resources/css/main.css') --}}
    </head>
    <body>
        <x-header />

        {{ $slot }}

        <x-footer />
    </body>
</html>
