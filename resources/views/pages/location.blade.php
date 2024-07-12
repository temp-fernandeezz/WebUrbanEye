<x-base-layout>
    <section class="bg-musgo h-[30vh] mb-12">
        <div class="max-w-7xl mx-auto pt-[10.3rem]">
            <form id="search-form" method="POST" class="flex">
                @csrf
                <label for="default-search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search</label>
                <div class="relative w-full">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="search" id="default-search"
                        class="block p-4 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Pesquise o local desejado" name="search_term" required>
                    <button type="submit"
                        class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Pesquisar</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Mapa do Google -->
    <section class="max-w-7xl mx-auto my-4">
        <div id="map" class="w-full h-[650px]"></div>
    </section>

    <section>
        <div class="max-w-7xl mx-auto mb-4">
            <div class="mb-5">
                <p class="text-2xl text-musgo font-semibold">
                    Legenda dos ícones
                </p>
            </div>
            <div class="flex gap-4 items-center">
                <div>
                    <img class="w-16" src="https://cdn-icons-png.flaticon.com/512/12843/12843392.png"
                        alt="Imagem Alert Location">
                </div>
                <div>
                    <p class="text-musgo text-lg">
                        Local de Risco - Alagamento
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal para mensagem de erro -->
    <div id="error-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <p class="text-red-500 text-lg">Opa, não temos informações sobre este local ainda</p>
            <button id="close-modal" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg">Fechar</button>
        </div>
    </div>

    <!-- Inclua o script do Google Maps API com sua chave -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBn0Hr_x0v-_EhdIbcEbF_H_AKEuqbMcLc&callback=initMap" async
        defer></script>
    <script>
        let map;
        let markers = [];
        let geocoder;

        function initMap() {
            try {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: { lat: -23.550520, lng: -46.633308 }, // Centro do mapa, São Paulo
                    zoom: 12,
                });
                geocoder = new google.maps.Geocoder(); // Inicializa o serviço de geocodificação
                loadApprovedLocations();
                setInterval(loadApprovedLocations, 30000); // Atualiza a cada 30 segundos
            } catch (error) {
                console.error('Erro ao inicializar o mapa:', error);
            }
        }

        function loadApprovedLocations() {
            fetch('/reports/approved-locations')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao buscar localizações aprovadas: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Dados recebidos da API:', data);
                    if (!Array.isArray(data)) {
                        console.error('Dados inválidos recebidos da API:', data);
                        return;
                    }
                    clearMarkers();
                    data.forEach(report => {
                        const latitude = parseFloat(report.latitude);
                        const longitude = parseFloat(report.longitude);
                        const description = report.description;

                        if (latitude && longitude && isValidCoordinate(latitude, longitude)) {
                            addMarker({ lat: latitude, lng: longitude }, description);
                        } else {
                            // Geocodificar usando o CEP (aqui assumimos que o CEP está em `report.address`)
                            if (report.address) {
                                geocodeAddress(report.address, description);
                            } else {
                                console.error('Endereço ausente para geocodificação.');
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Erro ao buscar localizações aprovadas:', error);
                });
        }

        function geocodeAddress(address, description) {
            geocoder.geocode({ address: address }, (results, status) => {
                if (status === 'OK') {
                    if (results[0] && results[0].geometry && results[0].geometry.location) {
                        const location = results[0].geometry.location;
                        addMarker({ lat: location.lat(), lng: location.lng() }, description);
                    } else {
                        console.error('Resultado da geocodificação sem localização válida.');
                    }
                } else {
                    console.error('Geocodificação falhou: ' + status);
                }
            });
        }

        function addMarker(location, description) {
            if (location && location.lat && location.lng && description) {
                let marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: description,
                    icon: {
                        url: 'https://cdn-icons-png.flaticon.com/512/12843/12843392.png',
                        scaledSize: new google.maps.Size(32, 32) // Define a altura e a largura do ícone (ex: 32x32 pixels)
                    }
                });
                markers.push(marker);
            } else {
                console.error('Dados inválidos para adicionar o marcador:', location, description);
            }
        }

        function clearMarkers() {
            markers.forEach(marker => marker.setMap(null));
            markers = [];
        }

        function isValidCoordinate(lat, lng) {
            return !isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180;
        }

        // Adiciona a funcionalidade de pesquisa
        document.getElementById('search-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const searchTerm = document.getElementById('default-search').value;

            fetch(`/search-location?search_term=${encodeURIComponent(searchTerm)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao buscar a localização: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.latitude && data.longitude) {
                        const location = { lat: data.latitude, lng: data.longitude };
                        if (isValidCoordinate(location.lat, location.lng)) {
                            // Zoom no local pesquisado e centraliza o mapa
                            map.setCenter(location); // Define o centro do mapa
                            map.setZoom(14);  // Define um zoom mais próximo
                            clearMarkers();
                            addMarker(location, data.description);
                        } else {
                            console.error('Coordenadas inválidas para a localização:', location);
                        }
                    } else {
                        // Exibir o modal se não houver informações sobre o local
                        document.getElementById('error-modal').classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar a localização:', error);
                });
        });

        // Fecha o modal
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('error-modal').classList.add('hidden');
        });
    </script>
</x-base-layout>
