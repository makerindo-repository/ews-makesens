<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="pt-2 pb-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 flex flex-col gap-4">
            <h2 class="text-xl text-primary">
                <i class="fa-solid fa-home me-2"></i>
                Dashboard
            </h2>

            <!-- Summary Data -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm flex items-center gap-5">
                    <i class="fa-solid fa-microchip text-primary text-2xl"></i>
                    <div>
                        <p class="text-primary text-sm font-medium">Total IoT Node</p>
                        <span class="text-2xl text-primary font-bold">{{ $totalIoTNodes }} Node</span>
                    </div>
                </div>
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm flex items-center gap-5">
                    <i class="fa-solid fa-satellite text-primary text-2xl"></i>
                    <div>
                        <p class="text-primary text-sm font-medium">Total Publik Node</p>
                        <span class="text-2xl text-primary font-bold">{{ $totalPublicNodes }} Node</span>
                    </div>
                </div>
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm flex items-center gap-5">
                    <i class="fa-solid fa-location-dot text-primary text-2xl"></i>
                    <div>
                        <p class="text-primary text-sm font-medium">Total Lokasi</p>
                        <span class="text-2xl text-primary font-bold">{{ $totalLocation }} Lokasi</span>
                    </div>
                </div>
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm flex items-center gap-5">
                    <i class="fa-solid fa-users text-primary text-2xl"></i>
                    <div>
                        <p class="text-primary text-sm font-medium">Total Relawan</p>
                        <span class="text-2xl text-primary font-bold">{{ $totalVolunteer }} Relawan</span>
                    </div>
                </div>
            </div>

            <!-- Map, Weather Widget, Search Bar -->
            <div class="bg-white p-3 rounded-lg shadow-sm">
                <div class="relative w-full h-[70vh]">
                    <!-- Map -->
                    <div id="map" class="w-full h-full z-0"></div>

                    <!-- Search -->
                    <div class="absolute top-4 left-4 z-10">
                        <div class="bg-white shadow-md rounded-lg px-4 py-2 flex items-center w-80">
                            <!-- Icon Search -->
                            <i class="fa-solid fa-magnifying-glass text-primary"></i>
                            <input type="text" placeholder="Cari Node"
                                class="w-full outline-none border-0 focus:ring-0 text-sm text-gray-700 placeholder-gray-400" />
                        </div>
                    </div>

                    <!-- Widget Cuaca -->
                    {{-- <div class="absolute top-4 right-4 z-10">
                        <div class="bg-white shadow-md rounded-xl p-4 w-60">
                            <h3 class="text-sm font-semibold text-gray-700 mb-2">Cuaca Terkini</h3>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-3xl font-bold text-gray-800" id="temp">
                                        {{ $weather['temp'] ?? '--' }}&deg;C
                                    </p>
                                    <p class="text-xs text-gray-500">Suhu</p>
                                </div>
                                <div>
                                    <!-- Ikon cuaca utama, bisa diganti sesuai kode BMKG -->
                                    <i class="{{ $weather['icon'] ?? 'fas fa-question-circle text-gray-400' }} text-4xl" id="weatherIcon"></i>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-2 mt-4 text-xs text-gray-600">
                                <div class="flex flex-col items-center justify-center gap-1">
                                    <i class="fas fa-wind text-gray-500"></i>
                                    <span id="wind">{{ $weather['wind'] ?? '--' }} km/h</span>
                                </div>
                                <div class="flex flex-col items-center justify-center gap-1">
                                    <i class="fas fa-tint text-blue-500"></i>
                                    <span id="humidity">{{ $weather['humidity'] ?? '--' }} %</span>
                                </div>
                                <div class="flex flex-col items-center justify-center gap-1">
                                    <i class="fas fa-cloud-rain text-blue-400"></i>
                                    <span id="rain">{{ $weather['rain'] ?? '--' }} mm</span>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="absolute top-4 right-4 z-10">
                        <div class="bg-white shadow-md rounded-xl p-4 w-60">
                            <h3 class="text-sm font-semibold text-gray-700">Cuaca Terkini</h3>
                            <h3 class="text-xs text-gray-700 mb-2"><i
                                    class="fa-solid fa-location-dot text-primary me-1"></i>{{ $weather['desa'] . ', ' . $weather['kotkab'] . ', ' . $weather['provinsi'] }}
                            </h3>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-3xl font-bold text-gray-800">
                                        {{ $weather['temp'] ?? '--' }}°C
                                    </p>
                                    <p class="text-xs text-gray-500">Suhu</p>
                                </div>
                                <div>
                                    @if (!empty($weather['icon_url']))
                                        <img src="{{ $weather['icon_url'] }}" alt="Cuaca" class="w-12 h-12">
                                    @else
                                        <i class="fas fa-question-circle text-gray-400 text-4xl"></i>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-2 mt-4 text-xs text-gray-600">
                                <div class="flex flex-col items-center justify-center gap-1">
                                    <i class="fas fa-wind text-gray-500"></i>
                                    <span>{{ $weather['wind'] ?? '--' }} km/h</span>
                                </div>
                                <div class="flex flex-col items-center justify-center gap-1">
                                    <i class="fas fa-tint text-blue-500"></i>
                                    <span>{{ $weather['humidity'] ?? '--' }} %</span>
                                </div>
                                <div class="flex flex-col items-center justify-center gap-1">
                                    <i class="fas fa-cloud-rain text-blue-400"></i>
                                    <span>{{ $weather['rain'] ?? '--' }} mm</span>
                                </div>
                            </div>

                            <p class="text-xs text-center text-gray-500 mt-2">
                                {{ $weather['desc'] ?? '' }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Ringkasan -->
            <div>
                <h2 class="text-xl font-semibold mb-1.5">Ringkasan</h2>
                <p class="text-slate-500 text-sm">*Ringkasan kondisi potensi banjir berdasarkan data real-time dari
                    sensor IoT
                    yang tersebar di berbagai
                    titik pemantauan. Prediksi bersifat berbasis data pengamatan aktual.</p>
            </div>

            <!-- Filter & Prediksi AI -->
            <div class="flex flex-col justify-center gap-3">
                <!-- Form Filter -->
                {{-- <form id="filterForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <select id="device_id" name="device_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">NODE001</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="bg-primary text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fa-solid fa-filter"></i>
                            Filter
                        </button>
                        <button type="button" id="resetFilter"
                            class="ml-2 bg-transparent text-slate-500 px-4 py-2 rounded-md hover:bg-gray-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 border border-slate-500">
                            <i class="fa-solid fa-repeat"></i>
                            Reset
                        </button>
                    </div>
                </form> --}}

                <!-- Button Prediksi AI -->
                <button id="openModalBtn"
                    class="bg-green-600 hover:bg-green-800 text-white rounded-full px-3 py-2 w-auto ms-auto">
                    Prediksi AI <i class="fa-solid fa-star"></i>
                </button>

                <!-- Modal Select Node untuk show Prediksi AI -->
                <div id="prediksiModal"
                    class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6">
                        <!-- Modal Header -->
                        <div class="flex flex-col mb-4 gap-1">
                            <h2 class="text-lg font-semibold text-gray-700">Prediksi banjir di masa depan dengan AI</h2>
                            <p class="text-sm text-slate-500 leading-tight">
                                Berikut hasil prediksi rata-rata TMA dalam 7 hari ke depan
                            </p>
                        </div>

                        <!-- Modal Body (Table) -->
                        <div class="overflow-x-auto mb-4">
                            <table class="min-w-full border border-gray-300 rounded-lg">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border">Tanggal
                                        </th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border">
                                            Rata-rata TMA (cm)</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border">
                                            Prediksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Contoh data 7 row -->
                                    <tr>
                                        <td class="px-4 py-2 border text-sm">2025-10-02</td>
                                        <td class="px-4 py-2 border text-sm">120</td>
                                        <td class="px-4 py-2 border text-sm">Tidak Banjir</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border text-sm">2025-10-03</td>
                                        <td class="px-4 py-2 border text-sm">135</td>
                                        <td class="px-4 py-2 border text-sm">Berpotensi Banjir</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border text-sm">2025-10-04</td>
                                        <td class="px-4 py-2 border text-sm">140</td>
                                        <td class="px-4 py-2 border text-sm">Berpotensi Banjir</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border text-sm">2025-10-05</td>
                                        <td class="px-4 py-2 border text-sm">150</td>
                                        <td class="px-4 py-2 border text-sm">Berpotensi Banjir</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border text-sm">2025-10-06</td>
                                        <td class="px-4 py-2 border text-sm">160</td>
                                        <td class="px-4 py-2 border text-sm">Akan Banjir</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border text-sm">2025-10-07</td>
                                        <td class="px-4 py-2 border text-sm">170</td>
                                        <td class="px-4 py-2 border text-sm">Akan Banjir</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border text-sm">2025-10-08</td>
                                        <td class="px-4 py-2 border text-sm">180</td>
                                        <td class="px-4 py-2 border text-sm">Akan Banjir</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex justify-end space-x-2">
                            <button id="closeModalBtn"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-md px-4 py-2">
                                Tutup
                            </button>
                            {{-- <button class="bg-green-600 hover:bg-green-800 text-white rounded-md px-4 py-2">
                                Simpan
                            </button> --}}
                        </div>
                    </div>
                </div>


            </div>

            <!-- Chart TMA (Tinggi Muka Air) -->
            <div class="bg-white shadow-sm p-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Grafik TMA (Tinggi Muka Air)</h2>
                    <span class="text-sm font-semibold text-[#9009BD]">22 - 08 - 2025</span>
                </div>
                <div id="tmaChart" class="max-w-full"></div>
            </div>

            <!-- Tangkapan Kamera Node -->
            {{-- <div class="bg-white shadow-sm p-4">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-semibold">Tangkapan Kamera per IoT Node</h2>
                    <span class="text-sm font-semibold text-[#9009BD]">22 - 08 - 2025</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    <div class="border-2 border-slate-500 rounded-lg p-4 font-bold flex flex-col gap-3">
                        <div>
                            NODE0001
                        </div>
                        <div>
                            <img src="{{ asset('images/dummy-sensor-cam.jpg') }}" alt="Kamera Node"
                                class="w-full h-32">
                        </div>
                    </div>
                    <div class="border-2 border-slate-500 rounded-lg p-4 font-bold flex flex-col gap-3">
                        <div>
                            NODE0002
                        </div>
                        <div>
                            <img src="{{ asset('images/dummy-sensor-cam.jpg') }}" alt="Kamera Node"
                                class="w-full h-32">
                        </div>
                    </div>
                    <div class="border-2 border-slate-500 rounded-lg p-4 font-bold flex flex-col gap-3">
                        <div>
                            NODE0003
                        </div>
                        <div>
                            <img src="{{ asset('images/dummy-sensor-cam.jpg') }}" alt="Kamera Node"
                                class="w-full h-32">
                        </div>
                    </div>
                    <div class="border-2 border-slate-500 rounded-lg p-4 font-bold flex flex-col gap-3">
                        <div>
                            NODE0004
                        </div>
                        <div>
                            <img src="{{ asset('images/dummy-sensor-cam.jpg') }}" alt="Kamera Node"
                                class="w-full h-32">
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Daerah Rawan Banjir -->
            <div class="bg-white shadow-sm p-4">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-semibold">Daerah Rawan Banjir</h2>
                    <span class="text-sm font-semibold text-[#9009BD]">22 - 08 - 2025</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    <div class="border-2 border-yellow-500 rounded-lg p-4 font-bold flex flex-col gap-2">
                        <div>
                            NODE0001 - <span class="text-yellow-500">Waspada</span>
                        </div>
                        <p class="text-xs text-slate-500 font-normal">Jl. Rancanumpang, Rancanumpang, Kec. Gedebage,
                            Kota Bandung</p>
                    </div>
                    <div class="border-2 border-orange-500 rounded-lg p-4 font-bold flex flex-col gap-2">
                        <div>
                            NODE0002 - <span class="text-orange-500">Siaga</span>
                        </div>
                        <p class="text-xs text-slate-500 font-normal">Jl. Rancanumpang, Rancanumpang, Kec. Gedebage,
                            Kota Bandung</p>
                    </div>
                    <div class="border-2 border-red-500 rounded-lg p-4 font-bold flex flex-col gap-2">
                        <div>
                            NODE0003 - <span class="text-danger">Awas</span>
                        </div>
                        <p class="text-xs text-slate-500 font-normal">Jl. Rancanumpang, Rancanumpang, Kec. Gedebage,
                            Kota Bandung</p>
                    </div>
                </div>
            </div>

            <!-- Status Sensor per Node -->
            <div class="bg-white shadow-sm p-4">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-semibold">Status Sensor per IoT Node</h2>
                    <span class="text-sm font-semibold text-[#9009BD]">22 - 08 - 2025</span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    <div class="border-2 border-slate-500 rounded-lg p-4 font-bold flex flex-col">
                        <div>
                            NODE0001 - <span class="text-primary">100%</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-primary text-sm">Sensor TMA <i
                                    class="fa-solid fa-circle-check ms-0.5"></i></span>
                            <span class="text-primary text-sm">Kamera <i
                                    class="fa-solid fa-circle-check ms-0.5"></i></span>
                        </div>
                    </div>
                    <div class="border-2 border-slate-500 rounded-lg p-4 font-bold flex flex-col">
                        <div>
                            NODE0002 - <span class="text-primary">50%</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-primary text-sm">Sensor TMA <i
                                    class="fa-solid fa-circle-check ms-0.5"></i></span>
                            <span class="text-danger text-sm">Kamera <i
                                    class="fa-solid fa-circle-xmark ms-0.5"></i></span>
                        </div>
                    </div>
                    <div class="border-2 border-slate-500 rounded-lg p-4 font-bold flex flex-col">
                        <div>
                            NODE0003 - <span class="text-primary">0%</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-danger text-sm">Sensor TMA <i
                                    class="fa-solid fa-circle-xmark ms-0.5"></i></span>
                            <span class="text-danger text-sm">Kamera <i
                                    class="fa-solid fa-circle-xmark ms-0.5"></i></span>
                        </div>
                    </div>
                    <div class="border-2 border-slate-500 rounded-lg p-4 font-bold flex flex-col">
                        <div>
                            NODE0004 - <span class="text-primary">100%</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-primary text-sm">Sensor TMA <i
                                    class="fa-solid fa-circle-check ms-0.5"></i></span>
                            <span class="text-primary text-sm">Kamera <i
                                    class="fa-solid fa-circle-check ms-0.5"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Buzzer per Node -->
            <div class="bg-white shadow-sm p-4">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-semibold">Status Buzzer per IoT Node</h2>
                    <span class="text-sm font-semibold text-[#9009BD]">22 - 08 - 2025</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    <div class="border-2 border-slate-500 rounded-lg p-4 font-bold">
                        PUB0001 - <span class="text-primary">Aktif</span>
                    </div>
                    <div class="border-2 border-slate-500 rounded-lg p-4 font-bold">
                        PUB0002 - <span class="text-danger">Tidak Aktif</span>
                    </div>
                    <div class="border-2 border-slate-500 rounded-lg p-4 font-bold">
                        PUB0003 - <span class="text-primary">Aktif</span>
                    </div>
                    <div class="border-2 border-slate-500 rounded-lg p-4 font-bold">
                        PUB0004 - <span class="text-primary">Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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

            document.addEventListener("DOMContentLoaded", function() {
                // Render Chart TMA (Tinggi Muka Air)
                fetch("{{ url('/chart/tma') }}")
                    .then(res => res.json())
                    .then(data => {
                        var options = {
                            chart: {
                                type: 'area',
                                height: 320,
                                toolbar: {
                                    show: false
                                }
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 3
                            },
                            series: data.series,
                            xaxis: {
                                type: 'category',
                                title: {
                                    text: 'Waktu (Jam)'
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Tinggi Muka Air (cm)'
                                },
                                min: 20,
                                max: 180
                            },
                            fill: {
                                type: 'solid',
                                opacity: 0.2,
                                colors: ['#3b82f6']
                            },
                            colors: ['#3b82f6'],
                            markers: {
                                size: 4,
                                colors: ['#3b82f6'],
                                strokeColors: '#fff',
                                strokeWidth: 2
                            },
                            legend: {
                                position: 'bottom',
                                markers: {
                                    radius: 12
                                }
                            },
                            annotations: {
                                yaxis: [{
                                        y: 50,
                                        borderColor: '#22c55e',
                                        label: {
                                            text: 'Aman',
                                            style: {
                                                color: '#fff',
                                                background: '#22c55e'
                                            }
                                        }
                                    },
                                    {
                                        y: 100,
                                        borderColor: '#f97316',
                                        label: {
                                            text: 'Waspada',
                                            style: {
                                                color: '#fff',
                                                background: '#f97316'
                                            }
                                        }
                                    },
                                    {
                                        y: 149,
                                        borderColor: '#ef4444',
                                        label: {
                                            text: 'Awas',
                                            style: {
                                                color: '#fff',
                                                background: '#ef4444'
                                            }
                                        }
                                    }
                                ]
                            }
                        };

                        var chart = new ApexCharts(document.querySelector("#tmaChart"), options);
                        chart.render();
                    });

                // Ambil data dari backend
                fetch("{{ url('/map/data') }}")
                    .then(res => res.json())
                    .then(data => {
                        // Tampilkan marker IoT Node
                        data.nodes.forEach(node => {
                            L.marker([node.latitude, node.longitude])
                                .addTo(map)
                                .bindPopup(
                                    `<b>${node.name}</b><br>Lat: ${node.latitude}, Lng: ${node.longitude}`);
                        });

                        // Tampilkan polygon lokasi
                        data.locations.forEach(loc => {
                            if (loc.polygon) {
                                let geojson = JSON.parse(loc.polygon);
                                L.geoJSON(geojson, {
                                    style: {
                                        color: '#3b82f6', // garis biru
                                        weight: 2,
                                        fillColor: '#3b82f6',
                                        fillOpacity: 0.2
                                    }
                                }).addTo(map).bindPopup(`<b>${loc.name}</b>`);
                            }
                        });
                    });

                // var options = {
                //     chart: {
                //         type: 'area',
                //         height: 320,
                //         toolbar: {
                //             show: false
                //         },
                //     },
                //     stroke: {
                //         curve: 'smooth',
                //         width: 3
                //     },
                //     series: [{
                //         name: 'TMA (cm)',
                //         data: [80, 85, 90, 95, 100, 110, 125, 135, 145, 150, 160, 170, 165, 160, 155, 150,
                //             145, 140,
                //             130, 120, 110, 100, 90, 85
                //         ]
                //     }],
                //     xaxis: {
                //         categories: [
                //             '00:00', '01:00', '02:00', '03:00', '04:00', '05:00',
                //             '06:00', '07:00', '08:00', '09:00', '10:00', '11:00',
                //             '12:00', '13:00', '14:00', '15:00', '16:00', '17:00',
                //             '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'
                //         ],
                //         title: {
                //             text: 'Waktu (Jam)'
                //         }
                //     },
                //     yaxis: {
                //         title: {
                //             text: 'Tinggi Muka Air (cm)'
                //         },
                //         min: 20,
                //         max: 180
                //     },
                //     fill: {
                //         type: 'solid',
                //         opacity: 0.2,
                //         colors: ['#3b82f6']
                //     },
                //     colors: ['#3b82f6'],
                //     markers: {
                //         size: 4,
                //         colors: ['#3b82f6'],
                //         strokeColors: '#fff',
                //         strokeWidth: 2
                //     },
                //     legend: {
                //         position: 'bottom',
                //         markers: {
                //             radius: 12
                //         }
                //     },
                //     annotations: {
                //         yaxis: [{
                //                 y: 100,
                //                 borderColor: '#f59e0b',
                //                 label: {
                //                     text: 'Waspada',
                //                     style: {
                //                         color: '#fff',
                //                         background: '#f59e0b'
                //                     }
                //                 }
                //             },
                //             {
                //                 y: 140,
                //                 borderColor: '#f97316',
                //                 label: {
                //                     text: 'Siaga',
                //                     style: {
                //                         color: '#fff',
                //                         background: '#f97316'
                //                     }
                //                 }
                //             },
                //             {
                //                 y: 170,
                //                 borderColor: '#ef4444',
                //                 label: {
                //                     text: 'Awas',
                //                     style: {
                //                         color: '#fff',
                //                         background: '#ef4444'
                //                     }
                //                 }
                //             }
                //         ]
                //     }
                // };

                // var chart = new ApexCharts(document.querySelector("#tmaChart"), options);
                // chart.render();

                // Open Modal Select Node
                const openModalBtn = document.getElementById('openModalBtn');
                const closeModalBtn = document.getElementById('closeModalBtn');
                const modal = document.getElementById('prediksiModal');

                openModalBtn.addEventListener('click', () => {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });

                closeModalBtn.addEventListener('click', () => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                });

                // Klik di luar modal untuk close
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                });
            });
        </script>
    @endpush

</x-app-layout>
