<x-app-layout>
    @push('styles')
        <style>
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                padding: 0.25rem 0.75rem !important;
                margin: 1rem 0.25rem !important;
                border: 1px solid #d1d5db !important;
                /* gray-300 */
                border-radius: 0.5rem !important;
                /* rounded-md */
                font-size: 1rem !important;
                /* text-sm */
                color: #374151;
                /* gray-700 */
                background-color: #ffffff !important;
                /* white */
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                background-color: #f3f4f6 !important;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background-color: #2185c7 !important;
                /* blue-600 */
                color: #ffffff !important;
                /* white */
                font-weight: 600 !important;
                /* font-semibold */
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
                background-color: #05619f !important;
                /* blue-600 */
                color: #ffffff !important;
                /* white */
            }

            .dataTables_filter {
                margin: 0 !important;
                position: relative;
                /* penting untuk ikon */
            }

            .dataTables_filter input {
                background-color: #dbeafe !important;
                /* biru muda */
                border: none !important;
                border-radius: 9999px !important;
                padding: 0.5rem 1rem !important;
                padding-left: 2rem !important;
                /* space buat ikon */
                font-size: 0.875rem !important;
                outline: none !important;
                width: 250px !important;
            }

            .dataTables_filter::before {
                content: "\f002";
                font-family: "Font Awesome 6 Free";
                font-weight: 900;
                position: absolute;
                left: 14px;
                top: 50%;
                transform: translateY(-50%);
                color: #2563eb;
                font-size: 14px;
                pointer-events: none;
            }
        </style>
    @endpush
    <x-slot name="header">
        <h2 class="leading-tight">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    {{ __('Data Master') }}
                </li>
                <li class="breadcrumb-item breadcrumb-active">{{ __('Data RAW') }}</li>
            </ol>
        </h2>
    </x-slot>

    <div class="pt-2 pb-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 flex flex-col gap-4">
            <h2 class="text-xl text-primary">
                <i class="fa-solid fa-gear me-2"></i>
                Data RAW Sensor
            </h2>

            <div x-data="{ open: {{ request()->has('start_date') || request()->has('end_date') ? 'true' : 'false' }} }" class="p-4 rounded-lg">
                <!-- Top bar -->
                <div class="flex items-center justify-end space-x-2">
                    <!-- Toggle Filter -->
                    <button @click="open = !open"
                        class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border rounded-lg shadow hover:bg-gray-50">
                        <i class="fa-solid fa-filter mr-2"></i>
                        Filter
                    </button>

                    <!-- Refresh -->
                    <button
                        class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border rounded-lg shadow hover:bg-gray-50"
                        type="button" onclick="window.location.reload();">
                        <i class="fa-solid fa-rotate mr-2"></i>
                        Refresh
                    </button>

                    <!-- Download -->
                    {{-- <button
                        class="flex items-center px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg shadow">
                        <i class="fa-solid fa-download mr-2"></i>
                        Download Data
                    </button> --}}
                </div>

                <!-- Filter Form -->
                <div x-show="open" x-transition class="mt-4 p-4 bg-white rounded-lg shadow">
                    <form method="GET" action="{{ route('raw-data.index') }}"
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Node -->
                        {{-- <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Node</label>
                            <select name="node"
                                class="w-full border-gray-300 bg-gray-100 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Node</option>
                                @foreach ($iotNodes as $node)
                                    <option value="{{ $node->id }}">{{ $node->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <!-- Tanggal Mulai -->
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Tanggal Awal</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="w-full border-gray-300 bg-gray-100 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Tanggal Akhir -->
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Tanggal Akhir</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="w-full border-gray-300 bg-gray-100 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Actions -->
                        <div class="flex items-end space-x-2">
                            <button type="submit"
                                class="flex items-center px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg shadow hover:bg-blue-700">
                                <i class="fa-solid fa-check mr-2"></i>
                                Terapkan Filter
                            </button>
                            <a href="{{ route('raw-data.index') }}"
                                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border rounded-lg shadow hover:bg-gray-50">
                                <i class="fa-solid fa-rotate-left mr-2"></i>
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm">
                <div class="overflow-x-scroll">
                    <table class="w-full align-middle border-slate-400 table mb-0 px-2" id="raw-data-table">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Jarak Sensor Ke Air</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ (float) $item->latitude }}</td>
                                    <td>{{ (float) $item->longitude }}</td>
                                    <td>{{ $item->distance }}cm</td>
                                    <td>{{ $item->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            // Get current timestamp for filename
            const timestamp = () => {
                const now = new Date();
                const date = now.getDate().toString().padStart(2, '0');
                const month = (now.getMonth() + 1).toString().padStart(2, '0');
                const year = now.getFullYear();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const seconds = now.getSeconds().toString().padStart(2, '0');

                return `${year}${month}${date}_${hours}${minutes}${seconds}`;
            }

            // DataTable (using jQuery)
            let table;
            $(document).ready(function() {
                table = $('#raw-data-table').DataTable({
                    responsive: true,
                    ordering: false,
                    dom: '<"dt-toolbar flex justify-between items-center bg-blue-500 px-4 py-2"<"toolbar-text">B>rtp',
                    buttons: [{
                        extend: 'excel',
                        text: 'Export Excel',
                        title: 'Data RAW',
                        className: 'bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600',
                        filename: function() {
                            return `data_raw_${timestamp()}`;
                        }
                    }],
                    initComplete: function() {
                        $('.toolbar-text').html(
                            '<span class="text-white font-bold text-lg"><i class="fa-solid fa-gear me-2"></i> Data RAW Sensor</span>'
                        )
                    },
                    // columnDefs: [{
                    //     className: "text-center",
                    //     targets: "_all"
                    // }],
                    language: {
                        emptyTable: "Tidak ada data raw yang tersedia",
                        paginate: {
                            previous: "<",
                            next: ">"
                        },
                        zeroRecords: "Data raw tidak ditemukan.",
                        // search: "" // kosongkan label "Search:"
                    }
                });

                // $('#raw-data-table_filter input').attr('placeholder', 'Cari Raw Data...');
            });

            // Alert berhasil
            // @if (session('success'))
            //     Swal.fire({
            //         icon: 'success',
            //         title: 'Berhasil!',
            //         text: '{{ session('success') }}',
            //         showConfirmButton: false,
            //         timer: 2000,
            //     });
            // @endif

            // Alert confirm delete
            // document.querySelectorAll('.delete-form').forEach(form => {
            //     form.addEventListener('submit', function(event) {
            //         event.preventDefault();

            //         const serialNumber = this.getAttribute('data-serial');
            //         Swal.fire({
            //             title: 'Konfirmasi',
            //             text: `Apakah Anda yakin ingin menghapus data node dengan nomor serial ${serialNumber}?`,
            //             icon: 'warning',
            //             showCancelButton: true,
            //             confirmButtonText: 'Ya, Hapus!',
            //             cancelButtonText: 'Batal'
            //         }).then((result) => {
            //             if (result.isConfirmed) {
            //                 this.submit();
            //             }
            //         });
            //     })
            // });
        </script>
    @endpush
</x-app-layout>
