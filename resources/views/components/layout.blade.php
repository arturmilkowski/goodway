<!doctype html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Good Way' }}</title>
        @vite('resources/css/main.css')
        <!-- font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Yeseva+One&display=swap" rel="stylesheet">
        <!-- /font -->
    </head>
    <body class="px-4 pt-4">
        <x-header />

        <main class="my-12">
            {{ $slot }}
        </main>

        <x-footer />
    </body>
</html>
