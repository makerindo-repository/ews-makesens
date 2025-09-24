<x-app-layout>
    <x-slot name="header">
        <h2 class="leading-tight">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    {{ __('Data Master') }}
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('location.index') }}">Data Lokasi</a>
                </li>
                <li class="breadcrumb-item breadcrumb-active">
                    {{ __('Edit Data Lokasi') }}
                </li>
            </ol>
        </h2>
    </x-slot>

    <div class="pt-2 pb-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 flex flex-col gap-4">
            <h2 class="text-xl text-primary">
                <i class="fa-solid fa-gear me-2"></i>
                Edit Lokasi
            </h2>

            <div class="flex justify-center items-center w-full">
                <div class="bg-white shadow-sm w-full md:w-5/6 lg:w-3/4 h-auto px-6 py-4 rounded-lg">
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold">Edit Data Lokasi</h3>
                        <p class="text-sm text-slate-500">Silakan isi semua informasi yang dibutuhkan</p>
                    </div>
                    <form action="{{ route('location.update', $location->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Hidden input untuk simpan GeoJSON -->
                            <input type="hidden" name="polygon" id="polygon" value="{{ $location->polygon }}">

                            <!-- Kolom kiri: Form -->
                            <div class="space-y-4">
                                <!-- Luas Area -->
                                <div>
                                    <label for="location_area" class="block text-sm font-medium mb-1">Luas Area
                                        (ha)</label>
                                    <input type="text" id="location_area" name="location_area"
                                        class="w-full border rounded-lg p-2 bg-gray-100" readonly />
                                </div>

                                <div>
                                    <x-input-label for="name">{{ __('Nama Lokasi') }}</x-input-label>
                                    <x-text-input id="name" class="block mt-1 w-full rounded-xl bg-gray-100"
                                        type="text" name="name" :value="$location->name ?? '-'" required autofocus
                                        autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="family_count">{{ __('Jumlah Keluarga') }}</x-input-label>
                                    <x-text-input id="family_count" class="block mt-1 w-full rounded-xl bg-gray-100"
                                        type="number" name="family_count" :value="$location->family_count ?? 0" required autofocus
                                        autocomplete="family_count" min="0" step="1" />
                                    <x-input-error :messages="$errors->get('family_count')" class="mt-2" />
                                </div>

                                <div class="flex mt-4 gap-3 items-center justify-end">
                                    <a href="{{ route('location.index') }}"
                                        class="bg-gray-200 text-slate-500 px-5 py-1.5 rounded-lg">Batal</a>
                                    <button type="submit"
                                        class="bg-primary text-white px-5 py-1.5 rounded-lg">Simpan</button>
                                </div>
                            </div>

                            <!-- Kolom kanan: Map -->
                            <div class="h-80 md:h-full">
                                <div id="map" class="w-full h-full rounded-lg"></div>
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

            // Layer untuk simpan polygon
            const drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);

            // Control draw
            const drawControl = new L.Control.Draw({
                edit: {
                    featureGroup: drawnItems
                },
                draw: {
                    polygon: true,
                    polyline: false,
                    rectangle: false,
                    circle: false,
                    marker: false,
                    circlemarker: false
                }
            });
            map.addControl(drawControl);

            // Event saat polygon digambar
            // --- Tampilkan polygon lama ---
            let existingPolygon = {!! $location->polygon !!}; // polygon dari DB
            if (existingPolygon) {
                const geoLayer = L.geoJSON(existingPolygon).addTo(drawnItems);
                map.fitBounds(geoLayer.getBounds());

                // Hitung luas area ulang dari polygon lama
                const latlngs = geoLayer.getLayers()[0].getLatLngs()[0];
                const area = L.GeometryUtil.geodesicArea(latlngs);
                const hektar = (area / 10000).toFixed(2);
                document.getElementById('location_area').value = hektar;

                // Simpan ke hidden input (biar tetap ikut form kalau tidak diubah)
                document.getElementById('polygon').value = JSON.stringify(existingPolygon);
            }

            // Event saat polygon baru dibuat
            map.on(L.Draw.Event.CREATED, function(event) {
                const layer = event.layer;
                drawnItems.clearLayers();
                drawnItems.addLayer(layer);

                const latlngs = layer.getLatLngs()[0];
                const area = L.GeometryUtil.geodesicArea(latlngs);
                const hektar = (area / 10000).toFixed(2);
                document.getElementById('location_area').value = hektar;

                const geojson = layer.toGeoJSON();
                document.getElementById('polygon').value = JSON.stringify(geojson);
            });

            // Event saat polygon diedit
            map.on(L.Draw.Event.EDITED, function(event) {
                event.layers.eachLayer(function(layer) {
                    const latlngs = layer.getLatLngs()[0];
                    const area = L.GeometryUtil.geodesicArea(latlngs);
                    const hektar = (area / 10000).toFixed(2);
                    document.getElementById('location_area').value = hektar;

                    const geojson = layer.toGeoJSON();
                    document.getElementById('polygon').value = JSON.stringify(geojson);
                });
            });
        </script>
    @endpush
</x-app-layout>
