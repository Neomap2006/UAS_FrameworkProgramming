<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $guestTitle = $title ?? null;
            if (!$guestTitle) {
                if (request()->routeIs('register*')) {
                    $guestTitle = 'Pendaftaran Akun';
                } elseif (request()->routeIs('password.*')) {
                    $guestTitle = 'Reset Password';
                } else {
                    $guestTitle = 'Login';
                }
            }
        @endphp
        <title>{{ $guestTitle }} - Portal Akademik & E-KYC</title>
        <link rel="icon" type="image/png" href="{{ asset('image/landing/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans text-slate-800 antialiased bg-slate-50 selection:bg-blue-600 selection:text-white min-h-screen">
        {{ $slot }}
    </body>
</html>
