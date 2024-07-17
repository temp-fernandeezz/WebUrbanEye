<header class="bg-black flex items-center justify-between py-4 px-8 md:px-12 mx-auto z-50 h-auto w-full" x-cloak
    x-data="{ openMenu: false }">
    <div>
        <a href="{{ route('home') }}">
            <img class="w-48" src="{{ Vite::asset('resources/images/new-logo-pce.png') }}" alt="Logo Paulo Rifas Branco">
        </a>
    </div>

    <!-- Botão do Menu para telas pequenas -->
    <button @click="openMenu = !openMenu" class="block lg:hidden text-white focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Menu Modal para telas pequenas -->
    <div x-show="openMenu" @click.outside="openMenu = false"
        class="fixed right-0 top-4 bg-black bg-opacity-75 z-50 flex flex-col items-start p-8 lg:hidden">
        <button @click="openMenu = false" class="text-white right-12 top-4 bg-black absolute mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <nav class="flex flex-col items-start gap-4 bg-black p-4 w-64">
            <x-nav-link :href="route('about')" :active="request()->routeIs('about')" class="text-white py-2 px-4 hover:text-gold-1">
                Sobre Nós
            </x-nav-link>
            <x-nav-link :href="route('location')" :active="request()->routeIs('location')" class="text-white py-2 px-4 hover:text-gold-1">
                Buscar Locais
            </x-nav-link>
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white py-2 px-4 hover:text-gold-1">
                Realizar Reclamação
            </x-nav-link>
            <x-nav-link :href="route('blog')" :active="request()->routeIs('blog')" class="text-white py-2 px-4 hover:text-gold-1">
                Blog
            </x-nav-link>
            <x-nav-link :href="route('login')" :active="request()->routeIs('login')" class="text-white py-2 px-4 hover:text-gold-1">
                Login
            </x-nav-link>
            <x-nav-link :href="route('register')" :active="request()->routeIs('register')" class="text-white py-2 px-4 hover:text-gold-1">
                Cadastre-se
            </x-nav-link>
        </nav>
    </div>

    <!-- Menu para telas grandes -->
    <nav class="hidden lg:flex gap-4">
        <x-nav-link :href="route('about')" :active="request()->routeIs('about')" class="group">
            <button class="rounded-xl bg-transparent border-0 px-6 py-3 capitalize group-hover:text-gold-1 text-white">
                Sobre Nós
            </button>
        </x-nav-link>

        <x-nav-link :href="route('location')" :active="request()->routeIs('location')" class="group">
            <button class="rounded-xl bg-transparent border-0 px-6 py-3 capitalize group-hover:text-gold-1 text-white">
                Buscar Locais
            </button>
        </x-nav-link>

        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="group">
            <button class="rounded-xl bg-transparent border-0 px-6 py-3 capitalize group-hover:text-gold-1 text-white">
                Realizar Reclamação
            </button>
        </x-nav-link>

        <x-nav-link :href="route('blog')" :active="request()->routeIs('blog')" class="group">
            <button class="rounded-xl bg-transparent border-0 px-6 py-3 capitalize group-hover:text-gold-1 text-white">
                Blog
            </button>
        </x-nav-link>

        <x-nav-link :href="route('login')" :active="request()->routeIs('login')" class="group">
            <button class="rounded-xl bg-transparent border-0 px-6 py-3 capitalize group-hover:text-gold-1 text-white">
                Login
            </button>
        </x-nav-link>

        <x-nav-link :href="route('register')" :active="request()->routeIs('register')" class="group">
            <button class="rounded-xl bg-transparent border-0 px-6 py-3 capitalize group-hover:text-gold-1 text-white">
                Cadastre-se
            </button>
        </x-nav-link>
    </nav>
</header>