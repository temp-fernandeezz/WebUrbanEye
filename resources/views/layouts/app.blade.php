<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>UrbanEye</title>
    <link rel="icon" type="icon" sizes="16x16" href="{{ Vite::asset('resources/images/new-ico.ico') }}">
    <meta name="description" content="A UrbanEye é um site voltado para a segurança de todos os cidadões">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .lds-dual-ring {
            display: inline-block;
            width: 80px;
            height: 80px;
            position: absolute;
            transform: scale(3.3)
        }

        .lds-dual-ring:after {
            content: " ";
            display: block;
            width: 64px;
            height: 64px;
            margin: 8px;
            border-radius: 50%;
            border: 2px solid #E3B873;
            border-color: #E3B873 transparent #E3B873 transparent;
            animation: lds-dual-ring 1.4s linear infinite;
        }

        @keyframes lds-dual-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #102122;
            z-index: 99999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.6s;
        }

        .loading-screen.hide {
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>
<div class="loading-screen" id="loading-screen">
    <div class="lds-dual-ring"></div>
    <img width="140" src="{{ Vite::asset('resources/images/gif-urban.gif') }}" alt="Logo PCE">
</div>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')
        @if (isset($header))
            <header class="bg-black shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
<script>
    window.addEventListener('DOMContentLoaded', function() {
    const loading = document.querySelector('#loading-screen');
    
    // Adiciona um atraso de 2 segundos (2000 milissegundos)
    setTimeout(function() {
        loading.classList.add('hide');
    }, 4000);
});

</script>

</html>