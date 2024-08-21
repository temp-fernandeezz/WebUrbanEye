<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>UrbanEye</title>
    <link rel="icon" type="icon" sizes="16x16" href="{{ Vite::asset('resources/images/new-ico.ico') }}">
    <meta name="description" content="A UrbanEye é um site voltado para a segurança de todos os cidadões">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

    @vite('resources/css/app.css')

    <style>
        [x-cloack] {
            display: none !important;
        }

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
            background-color: #00261a;
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

<body class="bg-[#e1ddd2]">
    <x-layout.header />
    <main>
        {{ $slot }}
    </main>
    <x-layout.footer />
    @vite('resources/js/app.js')
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
