<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blueGray-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                        {{ __('Lista de Denúncias') }}
                    </h2>

                    <div class="mb-4">
                        @foreach ($reports as $report)
                            <div class="mb-4">
                                <button class="accordion bg-gray-200 p-4 w-full text-left flex justify-between">
                                    <span><strong>Rua:</strong> {{ $report->address }}</span>
                                    <span class="ml-4"><strong>Data:</strong>
                                        {{ $report->created_at->format('d/m/Y') }}</span>
                                    <span class="ml-4"><strong>Status:</strong>
                                        @if ($report->status === 'pending')
                                            <span class="text-yellow-500">Pendente</span>
                                        @elseif ($report->status === 'approved')
                                            <span class="text-green-500">Aprovado</span>
                                        @else
                                            <span class="text-red-500">Rejeitado</span>
                                        @endif
                                    </span>
                                    <span>
                                        <svg class="w-6 h-6" fill="#000000" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g data-name="Layer 2">
                                                    <g data-name="arrow-ios-downward">
                                                        <rect width="14" height="14" opacity="0"></rect>
                                                        <path
                                                            d="M12 16a1 1 0 0 1-.64-.23l-6-5a1 1 0 1 1 1.28-1.54L12 13.71l5.36-4.32a1 1 0 0 1 1.41.15 1 1 0 0 1-.14 1.46l-6 4.83A1 1 0 0 1 12 16z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </span>
                                </button>
                                <div class="accordion-content hidden bg-gray-200 p-4">
                                    <p><strong>Tipo:</strong>
                                        {{ $report->type === 'flood' ? 'Alagamento' : 'Descarte Irregular de Lixo' }}
                                    </p>
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
                                        <p><strong>Imagem:</strong> <a
                                                href="{{ Storage::url('public/images/' . $report->image_path) }}"
                                                target="_blank" class="text-blue-500">Ver Imagem</a></p>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var accordions = document.querySelectorAll('.accordion');
            accordions.forEach(function(accordion) {
                accordion.addEventListener('click', function() {
                    this.classList.toggle('active');
                    var panel = this.nextElementSibling;
                    if (panel.style.display === 'block') {
                        panel.style.display = 'none';
                    } else {
                        panel.style.display = 'block';
                    }
                });
            });
        });
    </script>
</x-app-layout>
