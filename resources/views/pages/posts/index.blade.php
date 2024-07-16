<x-base-layout>
    <div class="max-w-7xl mx-auto p-4">
        <div class="bg-white rounded-lg shadow-md overflow-hidden p-6">
            <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
            @if($post->banner)
                <img src="{{ asset('storage/' . $post->banner) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover mb-6">
            @endif
            <div class="flex flex-wrap mb-4">
                
            </div>
          {!! $post->content !!}
        </div>
    </div>
</x-base-layout>