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
                    {{ __('Edit Data') }}
                </li>
            </ol>
        </h2>
    </x-slot>

    <div class="pt-2 pb-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 flex flex-col gap-4">
            <h2 class="text-xl text-primary">
                <i class="fa-solid fa-gear me-2"></i>
                Edit Publik Node
            </h2>

            <div class="flex justify-center items-center w-full">
                <div class="bg-white shadow-sm w-full md:w-5/6 lg:w-3/4 h-auto px-6 py-4 rounded-lg">
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold">Edit Data Publik Node</h3>
                        <p class="text-sm text-slate-500">Silakan isi semua informasi yang dibutuhkan</p>
                    </div>
                    <form action="{{ route('public-node.update', $pubNode->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="serial_number">{{ __('Nomor Serial') }}</x-input-label>
                                    <x-text-input id="serial_number" class="block mt-1 w-full rounded-xl bg-gray-100"
                                        type="text" name="serial_number" :value="$pubNode->serial_number" required autofocus
                                        autocomplete="serial_number" />
                                    <x-input-error :messages="$errors->get('serial_number')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="name">{{ __('Nama Node') }}</x-input-label>
                                    <x-text-input id="name" class="block mt-1 w-full rounded-xl bg-gray-100"
                                        type="text" name="name" :value="$pubNode->name" required autofocus
                                        autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="coordinate">{{ __('Titik Lokasi') }}</x-input-label>
                                    <x-text-input id="coordinate" class="block mt-1 w-full rounded-xl bg-gray-100"
                                        type="text" name="coordinate" :value="$pubNode->latitude . ',' . $pubNode->longitude" required readonly />
                                    <x-input-error :messages="$errors->get('coordinate')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="iot_node">{{ __('IoT Node') }}</x-input-label>
                                    <select id="iot_node" class="block mt-1 w-full rounded-xl bg-gray-100"
                                        name="iot_node" required>
                                        <option value="">--- Pilih IoT node ---</option>
                                        @foreach ($iotNodes as $node)
                                            <option value="{{ $node->id }}" @selected($node->id == $pubNode->iot_node_id)>
                                                {{ $node->name }}</option>
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
            let lat = parseFloat("{{ $pubNode->latitude }}");
            let lng = parseFloat("{{ $pubNode->longitude }}");
            var map = L.map('map').setView([lat, lng], 13);

            // Menambahkan layer peta Google Maps Satelit
            L.tileLayer('https://www.google.cn/maps/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
                attribution: '&copy; Google Hybrid',
                maxZoom: 18,
            }).addTo(map);

            let marker = L.marker([lat, lng]).addTo(map);

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                document.getElementById('coordinate').value = e.latlng.lat + ',' + e.latlng.lng;
            });
        </script>
    @endpush
</x-app-layout>
