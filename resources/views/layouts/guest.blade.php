@props(['fullBleed' => false])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LP3I College') }} - Portal</title>
        <link rel="icon" type="image/png" href="{{ file_exists(public_path('image/landing/logo.png')) ? asset('image/landing/logo.png') : asset('storage/image/landing/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans text-slate-800 antialiased bg-slate-50 selection:bg-blue-600 selection:text-white">
        @if ($fullBleed)
            {{ $slot }}
        @else
            <div class="min-h-screen flex flex-col sm:justify-center items-center py-8 sm:py-12 px-4 bg-gradient-to-br from-slate-50 via-blue-50/40 to-slate-100">
                <div class="mb-6 text-center">
                    <a href="/" class="inline-flex items-center gap-3 group">
                        <img src="{{ file_exists(public_path('image/landing/logo.png')) ? asset('image/landing/logo.png') : asset('storage/image/landing/logo.png') }}"
                             alt="Logo LP3I"
                             class="h-14 w-auto object-contain transition-transform duration-200 group-hover:scale-105">
                    </a>
                </div>

                <div class="w-full sm:max-w-md bg-white p-8 rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-200/80">
                    {{ $slot }}
                </div>
            </div>
        @endif
    </body>
</html>
