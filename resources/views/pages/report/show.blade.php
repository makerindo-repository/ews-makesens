<x-app-layout>
    <x-slot name="header">
        <h2 class="leading-tight">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('report.index') }}">Laporan</a>
                </li>
                <li class="breadcrumb-item breadcrumb-active">{{ __('Detail Laporan') }}</li>
            </ol>
        </h2>
    </x-slot>

    <div class="pt-2 pb-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 flex flex-col gap-4">
            <h2 class="text-xl text-primary">
                <i class="fa-solid fa-clipboard me-2"></i>
                Detail Laporan
            </h2>

            <div class="bg-white rounded-lg p-4 flex gap-3 w-full">
                <div class="w-1/5">
                    <img src="{{ asset('images/dummy-sensor-cam.jpg') }}" alt="Detail Laporan"
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="flex flex-col gap-7">
                    <div>
                        <h3 class="text-2xl font-semibold">Kejadian: {{ $report->jenis_kejadian }}</h3>
                        {{-- <p class="text-sm text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Quisquam, quos.</p> --}}
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold">{{ $report->kelurahan }}, {{ $report->kecamatan }}</h3>
                        <p class="text-sm text-gray-500"><i
                                class="fa-solid fa-location-dot me-2"></i>{{ $report->alamat_lengkap }}</p>
                    </div>

                    <div class="flex space-x-8">
                        <button id="tab-kejadian" class="tab-btn active-tab"
                            onclick="switchTab('kejadian')">Kejadian</button>
                        <button id="tab-korban" class="tab-btn" onclick="switchTab('korban')">Korban</button>
                        <button id="tab-foto" class="tab-btn" onclick="switchTab('foto')">Foto Kejadian</button>
                    </div>
                </div>
            </div>

            <!-- TAB CONTENTS -->
            <div id="content-kejadian" class="tab-content">
                <div class="bg-white p-4 rounded-lg">
                    <p class="font-semibold mb-4 text-xl">Lokasi: <span
                            id="lokasi">{{ (float) $report->latitude . ', ' . (float) $report->longitude }}</span>
                    </p>

                    <div class="flex flex-col md:flex-row gap-4">
                        <div id="map" class="basis-[30%] h-64 rounded"></div>
                        <div class="basis-[70%] space-y-3">
                            <div>
                                <p class="font-semibold">Penyebab</p>
                                <p id="penyebab">{{ $report->penyebab }}</p>
                            </div>
                            <div>
                                <p class="font-semibold">Kronologi</p>
                                <p id="kronologi">{{ $report->kronologi }}</p>
                            </div>
                            <div>
                                <p class="font-semibold">Dampak dan Tindak Lanjut</p>
                                <p id="dampak">{{ $report->dampak }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="content-korban" class="tab-content hidden">
                <div class="bg-white p-4 rounded-lg flex gap-4">
                    <div class="basis-1/2">
                        <p class="font-semibold mb-4 text-xl">Jumlah Korban:</p>
                        <div id="korban-list" class="space-y-2">
                            <div>
                                <p class="font-semibold">Pengungsi</p>
                                <p class="font-normal text-gray-500">{{ $report->pengungsi }} Jiwa</p>
                            </div>
                            <div>
                                <p class="font-semibold">Luka Ringan</p>
                                <p class="font-normal text-gray-500">{{ $report->luka_ringan }} Jiwa</p>
                            </div>
                            <div>
                                <p class="font-semibold">Luka Berat</p>
                                <p class="font-normal text-gray-500">{{ $report->luka_berat }} Jiwa</p>
                            </div>
                            <div>
                                <p class="font-semibold">Meninggal</p>
                                <p class="font-normal text-gray-500">{{ $report->meninggal }} Jiwa</p>
                            </div>
                        </div>
                    </div>
                    <div class="basis-1/2">
                        <p class="font-semibold mb-4 text-xl">Kebutuhan:</p>
                        <div id="kebutuhan-list" class="space-y-2">
                            <div>
                                <p class="font-semibold">Mendesak</p>
                                <p class="font-normal text-gray-500">{{ $report->kebutuhan_mendesak }}</p>
                            </div>
                            <div>
                                <p class="font-semibold">Bantuan</p>
                                <p class="font-normal text-gray-500">{{ $report->kebutuhan_bantuan }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="content-foto" class="tab-content hidden">
                <div class="bg-white p-4 rounded-lg">
                    <p class="font-semibold mb-4 text-xl">Foto Kejadian:</p>
                    <div id="foto-container" class="flex gap-4 flex-wrap"></div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
            // ========= DUMMY DATA =========
            const data = {
                kejadian: {
                    lokasi: '-6.200000, 106.816666',
                    penyebab: 'Curah hujan tinggi dan tanggul jebol.',
                    kronologi: 'Banjir terjadi setelah hujan deras selama 3 hari berturut-turut.',
                    dampak: 'Ratusan rumah terendam dan akses jalan utama tertutup lumpur.',
                    lat: -6.200000,
                    lng: 106.816666
                },
                korban: [{
                        label: 'Pengungsi',
                        jumlah: 200
                    },
                    {
                        label: 'Luka Berat',
                        jumlah: 50
                    },
                    {
                        label: 'Luka Ringan',
                        jumlah: 40
                    },
                    {
                        label: 'Meninggal Dunia',
                        jumlah: 7
                    }
                ],
                kebutuhan: [{
                        label: 'Makanan',
                        jumlah: 200
                    },
                    {
                        label: 'Peralatan',
                        jumlah: 200
                    },
                ],
                foto: [
                    'https://picsum.photos/200/200?random=1',
                    'https://picsum.photos/200/200?random=2'
                ]
            };

            // ========= TAB SYSTEM =========
            function switchTab(tab) {
                // Ubah tab aktif
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active-tab'));
                document.querySelector(`#tab-${tab}`).classList.add('active-tab');

                // Sembunyikan semua konten
                document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
                document.querySelector(`#content-${tab}`).classList.remove('hidden');

                // Render konten
                // if (tab === 'kejadian') renderKejadian();
                // if (tab === 'korban') renderKorban();
                if (tab === 'foto') renderFoto();
            }

            // ========= RENDER KEJADIAN =========
            function renderKejadian() {
                // document.getElementById('lokasi').textContent = data.kejadian.lokasi;
                // document.getElementById('dampak').textContent = data.kejadian.dampak;
                var lat = "{{ (float) $report->latitude }}";
                var lng = "{{ (float) $report->longitude }}";
                // Inisialisasi map Leaflet
                const map = L.map('map', {
                    center: [lat, lng], // Bandung
                    zoom: 15,
                    zoomControl: false // hilangkan tombol zoom
                });

                const markerIcon = L.icon({
                    iconUrl: "{{ asset('images/LocationMarker.svg') }}", // path gambar icon kamu
                    iconSize: [38, 38], // ukuran icon [width, height]
                    iconAnchor: [19, 38], // posisi anchor (titik bawah icon)
                    popupAnchor: [0, -38] // posisi popup relatif terhadap icon
                });

                L.tileLayer('https://www.google.cn/maps/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
                    attribution: '&copy; Google Hybrid',
                    maxZoom: 18,
                }).addTo(map);

                L.marker([lat, lng], {
                        icon: markerIcon
                    })
                    .addTo(map)
                    .bindPopup(`<b>Lokasi Kejadian</b><br>Lat:${lat}<br>Lng:${lng}`)
                    .openPopup();
            }

            // ========= RENDER KORBAN =========
            function renderKorban() {
                const container = document.getElementById('korban-list');
                const container2 = document.getElementById('kebutuhan-list');
                container.innerHTML = '';
                container2.innerHTML = '';
                data.korban.forEach(k => {
                    container.innerHTML += `
          <div>
            <p class="font-semibold">${k.label}</p>
            <p class="font-normal text-gray-500">${k.jumlah} Jiwa</p>
          </div>
        `;
                });
                data.kebutuhan.forEach(k => {
                    container2.innerHTML += `
            <div>
                <p class="font-semibold">${k.label}</p>
                <p class="font-normal text-gray-500">${k.jumlah}</p>
            </div>
        `;
                });
            }

            // ========= RENDER FOTO =========
            function renderFoto() {
                const container = document.getElementById('foto-container');
                container.innerHTML = '';
                data.foto.forEach(url => {
                    container.innerHTML += `<img src="${url}" class="w-32 h-32 object-cover rounded">`;
                });
            }

            // Load awal
            renderKejadian();
        </script>
    @endpush
</x-app-layout>
