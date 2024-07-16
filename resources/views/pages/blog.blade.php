<x-base-layout>
    <div class="bg-musgo h-44 border-b-2 border-gold-1">
        <h1 class="text-4xl font-bold text-gold-1 text-center title-home italic tracking-widest pt-20">Confira as nossas
            postagens</h1>
    </div>
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-10">
            @foreach ($posts as $post)
                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden w-[26rem] hover:shadow-lg transition-shadow duration-300">
                    @if ($post->banner)
                        <img src="{{ asset('storage/' . $post->banner) }}" alt="{{ $post->title }}"
                            class="w-full h-48 object-cover">
                    @endif
                    <div class="p-4">
                        @if ($post->tags)
                            @foreach ($post->tags as $tag)
                                <span
                                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        @endif

                        <h2 class="text-xl font-semibold mb-2">{{ $post->title }}</h2>
                        <p class="text-gray-600">{{ $post->summary }}</p>
                        <a href="{{ route('posts.index', $post->id) }}"
                            class="text-indigo-600 hover:underline mt-4 inline-block">Leia mais</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-base-layout>
