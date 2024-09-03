<x-base-layout>
    <section class="bg-[#00261a] h-[30vh] mb-12">
        <div class="max-w-7xl mx-auto pt-[7.3rem] lh:px-0 px-4">
            <form id="search-form" method="POST" class="flex">
                @csrf
                <label for="default-search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search</label>
                <div class="relative w-full">
                    <div>
                        <p class="text-white text-sm -mt-4">*Por favor, faça a pesquisa pelo CEP (Código Postal) do
                            local.</p>
                    </div>
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="search" id="default-search"
                        class="bg-white block p-4 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Pesquise o local desejado" name="search_term" required>
                    <button type="submit"
                        class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Pesquisar</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Mapa do Google -->
    <section class="max-w-7xl mx-auto my-4">
        <div id="map" class="w-full h-[650px] lg:px-0 px-4"></div>
    </section>

    <section>
        <div class="max-w-7xl mx-auto mb-4">
            <div class="mb-5">
                <p class="text-2xl text-[#00261a] font-semibold">
                    Legenda dos ícones
                </p>
            </div>
            <div class="grid grid-cols-3 gap-4 items-center">
                <div class="flex gap-4 items-center">
                    <div>
                        <img class="w-16" src="https://cdn-icons-png.flaticon.com/512/12843/12843392.png"
                            alt="Imagem Alert Location">
                    </div>
                    <div>
                        <p class="text-[#00261a] text-lg">
                            Local de Alagamento
                        </p>
                    </div>
                </div>
                <div class="flex gap-4 items-center">
                    <div>
                        <img class="w-16" src="https://cdn-icons-png.flaticon.com/512/12843/12843392.png"
                            alt="Imagem Alert Location">
                    </div>
                    <div>
                        <p class="text-[#00261a] text-lg">
                            Local de Assaltos
                        </p>
                    </div>
                </div>
                <div class="flex gap-4 items-center">
                    <div>
                        <img class="w-16" src="https://cdn-icons-png.flaticon.com/512/12843/12843392.png"
                            alt="Imagem Alert Location">
                    </div>
                    <div>
                        <p class="text-[#00261a] text-lg">
                            Local de Descarte Irregular de Lixo
                        </p>
                    </div>
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

    <!-- Abaixo existe todo o código de exibição do mapa, mexa somente em caso de EXTREMA necessidade -->
    <script>
        let map;
        let markers = [];
        let geocoder;
        let robberyCircles = [];

        function initMap() {
            try {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {
                        lat: -23.550520,
                        lng: -46.633308
                    },
                    zoom: 12,
                });
                geocoder = new google.maps.Geocoder();
                loadApprovedLocations();
                setInterval(loadApprovedLocations, 30000);
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
                    clearCircles();
                    data.forEach(report => {
                        const latitude = parseFloat(report.latitude);
                        const longitude = parseFloat(report.longitude);
                        const description = report.description;
                        const type = report.type;

                        if (isValidCoordinate(latitude, longitude)) {
                            if (type === "robberies") {
                                addRobberyMarker({
                                    lat: latitude,
                                    lng: longitude
                                }, description);
                                addRobberyCircle({
                                    lat: latitude,
                                    lng: longitude
                                });
                            } else if (type === "theft") {
                                addTheftMarker({
                                    lat: latitude,
                                    lng: longitude
                                }, description);
                            } else if (type === "illegal_dump") {
                                addIllegalDumpMarker({
                                    lat: latitude,
                                    lng: longitude
                                }, description); // Novo marcador para "descarte ilegal"
                            } else {
                                addMarker({
                                    lat: latitude,
                                    lng: longitude
                                }, description);
                            }
                        } else if (report.address) {
                            geocodeAddress(report.address, description, type);
                        } else {
                            console.error('Endereço ausente para geocodificação.');
                        }
                    });
                })
                .catch(error => {
                    console.error('Erro ao buscar localizações aprovadas:', error);
                });
        }

        function geocodeAddress(address, description, type) {
            if (!address) {
                console.error('Endereço ausente para geocodificação.');
                return;
            }

            geocoder.geocode({
                address: address
            }, (results, status) => {
                if (status === 'OK') {
                    if (results[0] && results[0].geometry && results[0].geometry.location) {
                        const location = results[0].geometry.location;
                        if (type === "robberies") {
                            addRobberyMarker({
                                lat: location.lat(),
                                lng: location.lng()
                            }, description);
                            addRobberyCircle({
                                lat: location.lat(),
                                lng: location.lng()
                            });
                        } else if (type === "theft") {
                            addTheftMarker({
                                lat: location.lat(),
                                lng: location.lng()
                            }, description);
                        } else if (type === "illegal_dump") {
                            addIllegalDumpMarker({
                                lat: location.lat(),
                                lng: location.lng()
                            }, description);
                        } else {
                            addMarker({
                                lat: location.lat(),
                                lng: location.lng()
                            }, description);
                        }
                        if (markers.length === 0) {
                            map.setCenter({
                                lat: location.lat(),
                                lng: location.lng()
                            });
                            map.setZoom(14);
                        }
                    } else {
                        console.error('Resultado da geocodificação sem localização válida.');
                    }
                } else {
                    console.error('Geocodificação falhou: ' + status);
                    if (status === 'ZERO_RESULTS') {
                        document.getElementById('error-modal').classList.remove('hidden');
                    }
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
                        scaledSize: new google.maps.Size(32, 32)
                    }
                });
                markers.push(marker);
            } else {
                console.error('Dados inválidos para adicionar o marcador:', location, description);
            }
        }

        function addRobberyMarker(location, description) {
            if (location && location.lat && location.lng && description) {
                let marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: description,
                    icon: {
                        url: 'https://cdn-icons-png.flaticon.com/512/5828/5828047.png',
                        scaledSize: new google.maps.Size(32, 32)
                    }
                });
                markers.push(marker);
            } else {
                console.error('Dados inválidos para adicionar o marcador de assalto:', location, description);
            }
        }

        function addTheftMarker(location, description) {
            if (location && location.lat && location.lng && description) {
                let marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: description,
                    icon: {
                        url: 'https://cdn-icons-png.flaticon.com/512/3022/3022176.png',
                        scaledSize: new google.maps.Size(32, 32)
                    }
                });
                markers.push(marker);
            } else {
                console.error('Dados inválidos para adicionar o marcador de furto:', location, description);
            }
        }

        // Novo método para adicionar marcador de "descarte ilegal"
        function addIllegalDumpMarker(location, description) {
            if (location && location.lat && location.lng && description) {
                let marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: description,
                    icon: {
                        url: 'https://cdn-icons-png.flaticon.com/512/535/535239.png', // Ícone para "descarte ilegal"
                        scaledSize: new google.maps.Size(32, 32)
                    }
                });
                markers.push(marker);
            } else {
                console.error('Dados inválidos para adicionar o marcador de descarte ilegal:', location, description);
            }
        }

        function addRobberyCircle(location) {
            const circle = new google.maps.Circle({
                strokeColor: "#00261a",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#00261a",
                fillOpacity: 0.35,
                map: map,
                center: location,
                radius: 600,
            });
            robberyCircles.push(circle);
        }

        function clearMarkers() {
            markers.forEach(marker => marker.setMap(null));
            markers = [];
        }

        function clearCircles() {
            robberyCircles.forEach(circle => circle.setMap(null));
            robberyCircles = [];
        }

        function isValidCoordinate(lat, lng) {
            return !isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180;
        }

        document.getElementById('search-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const searchTerm = document.getElementById('default-search').value.trim();

            if (!searchTerm) {
                console.error('Termo de pesquisa vazio.');
                return;
            }

            geocoder.geocode({
                address: searchTerm
            }, (results, status) => {
                if (status === 'OK') {
                    const location = results[0].geometry.location;
                    const locationLat = location.lat();
                    const locationLng = location.lng();
                    if (isValidCoordinate(locationLat, locationLng)) {
                        map.setCenter({
                            lat: locationLat,
                            lng: locationLng
                        });
                        map.setZoom(14);
                        addMarker({
                            lat: locationLat,
                            lng: locationLng
                        }, searchTerm);
                    } else {
                        console.error('Coordenadas inválidas para o local pesquisado:', locationLat,
                            locationLng);
                    }
                } else {
                    console.error('Geocodificação falhou: ' + status);
                    document.getElementById('error-modal').classList.remove('hidden');
                }
            });
        });

        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('error-modal').classList.add('hidden');
        });
    </script>

</x-base-layout>
