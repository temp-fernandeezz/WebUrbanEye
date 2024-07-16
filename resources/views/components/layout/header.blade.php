<header
    class="bg-black flex grid-cols-1 items-center justify-between py-4 px-8 md:px-12 mx-auto z-50 h-auto w-full"
    x-cloak x-data="{ openMenu: false }" :class="openMenu ? 'overflow-hidden' : 'overflow-visible'">

    <div>
        <a href="{{ route('home') }}">
            <img class="w-48" src="{{ Vite::asset('resources/images/new-logo-pce.png') }}" alt="Logo Paulo Rifas Branco">
        </a>
    </div>

    <div class="flex gap-4">
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

        <div>
            <x-nav-link :href="route('login')" :active="request()->routeIs('login')" class="group">
                <button
                    class="rounded-xl bg-transparent border-0 px-6 py-3 capitalize group-hover:text-gold-1 text-white">
                    Login
                </button>
            </x-nav-link>
        </div>

        <div>
            <x-nav-link :href="route('register')" :active="request()->routeIs('register')" class="group">
                <button
                    class="rounded-xl bg-transparent border-0 px-6 py-3 capitalize group-hover:text-gold-1 text-white">
                    Cadastre-se
                </button>
            </x-nav-link>
        </div>
    </div>
</header>