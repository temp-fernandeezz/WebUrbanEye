<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <script src="https://kit.fontawesome.com/9c2d55022c.js" crossorigin="anonymous"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    {{-- <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/images/new-icon.ico') }}"> --}}
    @vite('resources/css/app.css')
</head>

<body class="bg-[#e1ddd2]">
    <x-layout.header />
    <main>
        {{ $slot }}
    </main>
    <x-layout.footer />
    @vite('resources/js/app.js')
</body>
