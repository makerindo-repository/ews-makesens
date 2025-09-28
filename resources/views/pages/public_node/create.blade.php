<x-app-layout>
    <x-slot name="header">
        <h2 class="leading-tight">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    {{ __('Data Master') }}
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public-node.index') }}">Publik Node</a>
                </li>
                <li class="breadcrumb-item breadcrumb-active">
                    {{ __('Tambah Data') }}
                </li>
            </ol>
        </h2>
    </x-slot>

    <div class="pt-2 pb-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 flex flex-col gap-4">
            <h2 class="text-xl text-primary">
                <i class="fa-solid fa-gear me-2"></i>
                Tambah Publik Node
            </h2>

            <div class="flex justify-center items-center w-full">
                <div class="bg-white shadow-sm w-full md:w-5/6 lg:w-3/4 h-auto px-6 py-4 rounded-lg">
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold">Tambah Data Publik Node</h3>
                        <p class="text-sm text-slate-500">Silakan isi semua informasi yang dibutuhkan</p>
                    </div>
                    <form action="{{ route('public-node.store') }}" method="post">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="serial_number">{{ __('Nomor Serial') }}</x-input-label>
                                    <x-text-input id="serial_number" class="block mt-1 w-full rounded-xl bg-gray-100"
                                        type="text" name="serial_number" :value="old('serial_number')" required autofocus
                                        autocomplete="serial_number" />
                                    <x-input-error :messages="$errors->get('serial_number')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="name">{{ __('Nama Node') }}</x-input-label>
                                    <x-text-input id="name" class="block mt-1 w-full rounded-xl bg-gray-100"
                                        type="text" name="name" :value="old('name')" required autofocus
                                        autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="coordinate">{{ __('Titik Lokasi') }}</x-input-label>
                                    <x-text-input id="coordinate" class="block mt-1 w-full rounded-xl bg-gray-100"
                                        type="text" name="coordinate" :value="old('coordinate')" required readonly />
                                    <x-input-error :messages="$errors->get('coordinate')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="iot_node">{{ __('IoT Node') }}</x-input-label>
                                    <select id="iot_node" class="block mt-1 w-full rounded-xl bg-gray-100"
                                        name="iot_node" required>
                                        <option value="">--- Pilih IoT node ---</option>
                                        @foreach ($iotNodes as $node)
                                            <option value="{{ $node->id }}">{{ $node->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('iot_node')" class="mt-2" />
                                </div>
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('public-node.index') }}"
                                        class="bg-gray-200 text-slate-500 px-5 py-1.5 rounded-lg">Batal</a>
                                    <button type="submit"
                                        class="bg-primary text-white px-5 py-1.5 rounded-lg">Simpan</button>
                                </div>
                            </div>
                            <div>
                                <!-- Map -->
                                <div class="h-80 md:h-full">
                                    <div id="map" class="w-full h-full rounded-lg"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <!-- Leaflet core -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

        <!-- Leaflet.draw (untuk menggambar polygon) -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
        <script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>

        <!-- Geometry util (untuk hitung luas) -->
        <script src="https://unpkg.com/leaflet-geometryutil"></script>
        <script>
            var map = L.map('map', {
                center: [-6.914744, 107.60981], // Bandung
                zoom: 13,
                zoomControl: false // hilangkan tombol zoom
            });

            // Menambahkan layer peta Google Maps Satelit
            L.tileLayer('https://www.google.cn/maps/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
                attribution: '&copy; Google Hybrid',
                maxZoom: 18,
            }).addTo(map);

            let marker;

            map.on('click', function(e) {
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker(e.latlng).addTo(map);

                // autofill ke input
                document.getElementById('coordinate').value = e.latlng.lat + ',' + e.latlng.lng;
            });

            // // Layer untuk simpan polygon
            // const drawnItems = new L.FeatureGroup();
            // map.addLayer(drawnItems);

            // // Control draw
            // const drawControl = new L.Control.Draw({
            //     edit: {
            //         featureGroup: drawnItems
            //     },
            //     draw: {
            //         polygon: true,
            //         polyline: false,
            //         rectangle: false,
            //         circle: false,
            //         marker: false,
            //         circlemarker: false
            //     }
            // });
            // map.addControl(drawControl);

            // // Event saat polygon digambar
            // map.on(L.Draw.Event.CREATED, function(event) {
            //     const layer = event.layer;
            //     drawnItems.clearLayers(); // hanya 1 polygon
            //     drawnItems.addLayer(layer);

            //     const latlngs = layer.getLatLngs()[0];
            //     const area = L.GeometryUtil.geodesicArea(latlngs); // m²
            //     const hektar = (area / 10000).toFixed(2); // ha

            //     // Isi input luas area
            //     document.getElementById('location_area').value = hektar;

            //     // Simpan polygon dalam format GeoJSON ke input hidden
            //     const geojson = layer.toGeoJSON();
            //     document.getElementById('polygon').value = JSON.stringify(geojson);
            // });
        </script>
    @endpush
</x-app-layout>
