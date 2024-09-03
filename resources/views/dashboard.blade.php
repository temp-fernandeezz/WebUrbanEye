<x-app-layout>
    <section>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-blueGray-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Modal Background -->
                        <div x-data="{ showModal: false }" x-init="@if ($errors->any()) showModal = true @endif" x-show="showModal"
                            class="fixed inset-0 flex items-center justify-center z-50" @keydown.escape.window="showModal = false">
                            <div class="fixed inset-0 bg-gray-900 opacity-50"></div>

                            <!-- Modal -->
                            <div
                                class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full p-6">
                                <!-- Modal Header -->
                                <div class="flex justify-between items-center pb-3">
                                    <p class="text-2xl font-bold">Mensagem</p>
                                    <button @click="showModal = false" class="text-black">
                                        <span class="text-2xl">&times;</span>
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div>
                                    @if (session('success'))
                                        <p class="text-green-500 text-2xl">{{ session('success') }}</p>
                                        <p class="text-black text-xl">Pedimos que aguarde uma resposta, logo entraremos em contato!</p>
                                    @endif

                                    @if ($errors->any())
                                        <div class="bg-red-100 text-red-800 p-4 mb-4">
                                            <p class="text-red-500 text-xl">Opa, encontramos alguns erros, por favor verifique se tudo está preenchido corretamente.</p>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex justify-end pt-2">
                                    <button @click="showModal = false"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Fechar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <form id="reportForm" action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <div class="flex flex-wrap">
                                <div class="w-full lg:w-4/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            for="postal_code">
                                            CEP (Código Postal)
                                        </label>
                                        <input type="text" id="postal_code" name="postal_code"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="{{ old('postal_code') }}">
                                        @error('postal_code')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-4/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            for="city">
                                            Cidade
                                        </label>
                                        <input type="text" id="city" name="city"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="{{ old('city') }}">
                                        @error('city')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-4/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            for="country">
                                            Estado
                                        </label>
                                        <input type="text" id="country" name="country"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="{{ old('country') }}">
                                        @error('country')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-full lg:w-12/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            for="address">
                                            Endereço
                                        </label>
                                        <input type="text" id="address" name="address"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="{{ old('address') }}">
                                        @error('address')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-12/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            for="image_path">
                                            Imagem
                                        </label>
                                        <input type="file" id="image_path" name="image_path"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                        @error('image_path')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-12/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            for="type">
                                            Tipo de Denúncia
                                        </label>
                                        <select id="type" name="type"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                            <option value="" disabled selected>Escolha um tipo</option>
                                            <option value="flood">Alagamento</option>
                                            <option value="robberies">Assalto</option>
                                            <option value="illegal_dump">Descarte Irregular de Lixo</option>
                                        </select>
                                        @error('type')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-12/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            for="description">
                                            Descrição
                                        </label>
                                        <textarea id="description" name="description" rows="4"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            placeholder="Descreva o problema">{{ old('description') }}</textarea>
                                        @error('description')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button id="submitButton" type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 focus:outline-none focus:ring w-full mt-4">Enviar
                                Denúncia</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const postalCodeInput = document.getElementById('postal_code');
            const form = document.getElementById('reportForm');
            const submitButton = document.getElementById('submitButton');

            postalCodeInput.addEventListener('blur', function() {
                const postalCode = postalCodeInput.value.replace(/\D/g, '');

                if (postalCode.length === 8) {
                    fetch(`https://viacep.com.br/ws/${postalCode}/json/`)
                        .then(response => response.json())
                        .then(data => {
                            if (!data.erro) {
                                document.getElementById('address').value = data.logradouro;
                                document.getElementById('city').value = data.localidade;
                                document.getElementById('country').value = data.uf;
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            });

            form.addEventListener('submit', function(event) {
                // Check for errors (this should be customized to your specific error-checking logic)
                const errors = @json($errors->any());

                if (errors) {
                    event.preventDefault();
                    document.querySelector('[x-data]').__x.$data.showModal = true;
                }
            });
        });
    </script>
</x-app-layout>
