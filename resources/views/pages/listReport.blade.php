<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blueGray-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                        {{ __('Lista de Denúncias') }}
                    </h2>
 
                    <div class="space-y-4">
                        @foreach ($reports as $report)
                            <div x-data="{ open: false }" :class="{'bg-[#f5e782]': '{{ $report->status }}' === 'pending', 'bg-[#98FB98]': '{{ $report->status }}' === 'approved', 'bg-[#ff999b]': '{{ $report->status }}' === 'rejected'}" class="relative overflow-hidden border-l-[0.4rem] rounded shadow-md">
                                <button @click="open = !open" class="w-full p-[0.7em] flex items-center justify-between cursor-pointer text-left transition-all duration-300 ease-in-out">
                                    <div class="text-4xl flex items-center justify-center">
                                        <h2 x-text="open ? '−' : '+'"></h2>
                                    </div>
                                    <h2 class="w-[80%] text-xs flex flex-col">
                                        <span><strong>Rua:</strong> {{ $report->address }}</span>
                                        <span><strong>Data:</strong> {{ $report->created_at->format('d/m/Y') }}</span>
                                        <span><strong>Status:</strong>
                                            @if ($report->status === 'pending')
                                                <span class="text-yellow-500">Pendente</span>
                                            @elseif ($report->status === 'approved')
                                                <span class="text-green-500">Aprovado</span>
                                            @else
                                                <span class="text-red-500">Rejeitado</span>
                                            @endif
                                        </span>
                                    </h2>
                                </button>
                                <div x-show="open" class="transition-all duration-[1s] ease-in-out max-h-screen p-[1rem] text-[0.8rem]">
                                    <p><strong>Tipo:</strong> {{ $report->type === 'flood' ? 'Alagamento' : 'Descarte Irregular de Lixo' }}</p>
                                    <p><strong>Endereço:</strong> {{ $report->address }}</p>
                                    <p><strong>Cidade:</strong> {{ $report->city }}</p>
                                    <p><strong>Estado:</strong> {{ $report->country }}</p>
                                    <p><strong>CEP:</strong> {{ $report->postal_code }}</p>
                                    <p><strong>Descrição:</strong> {{ $report->description }}</p>
                                    <p><strong>Status:</strong>
                                        @if ($report->status === 'pending')
                                            <span class="text-yellow-500">Pendente</span>
                                            <p class="text-yellow-600 mt-2">Ainda estamos analisando sua reclamação, pedimos que aguarde.</p>
                                        @elseif ($report->status === 'approved')
                                            <span class="text-green-500">Aprovado</span>
                                            <p class="text-green-600 mt-2">Sua reclamação foi aprovada, logo sua reclamação aparecerá no mapa.</p>
                                        @else
                                            <span class="text-red-500">Rejeitado</span>
                                            <p class="text-red-600 mt-2">Infelizmente não conseguimos aceitar sua reclamação, por favor, verifique se sua imagem está nítida e se o endereço coincide com a foto enviada.</p>
                                        @endif
                                    </p>
                                    @if ($report->image_path)
                                        <p><strong>Imagem:</strong> <a href="{{ Storage::url('public/images/' . $report->image_path) }}" target="_blank" class="text-blue-500">Ver Imagem</a></p>
                                    @else
                                        <p><strong>Imagem:</strong> Nenhuma Imagem</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
 
<!-- Alpine.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>