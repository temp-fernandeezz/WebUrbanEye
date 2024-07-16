<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pesquisa e Central de Enchentes</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ Vite::asset('resources/images/icons-rain.png') }}">
    <meta name="description" content="A P.C.E é um site voltado para a segurança de todos os cidadões">
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
    <img width="140" src="{{ Vite::asset('resources/images/new-logo-pce.png') }}" alt="Logo PCE">
</div>

<body class="font-sans bg-musgo antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100musgo">
        <div>
            <a href="/">
                <Image class="w-48" src="{{ Vite::asset('resources/images/new-logo-pce.png') }}" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>
<script>
    window.addEventListener('DOMContentLoaded', function() {
        const loading = document.querySelector('#loading-screen');
        loading.classList.add('hide');
    })
</script>

</html>