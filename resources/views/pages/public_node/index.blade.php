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
                <li class="breadcrumb-item breadcrumb-active">{{ __('Publik Node') }}</li>
            </ol>
        </h2>
    </x-slot>

    <div class="pt-2 pb-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 flex flex-col gap-4">
            <h2 class="text-xl text-primary">
                <i class="fa-solid fa-gear me-2"></i>
                Data Publik Node
            </h2>

            <a href="{{ route('public-node.create') }}"
                class="bg-primary text-white w-auto ms-auto rounded-lg py-2 px-3 flex justify-between items-center gap-2">
                <i class="fa-solid fa-circle-plus"></i>
                Tambah Node
            </a>
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="overflow-x-scroll">
                    <table class="w-full align-middle border-slate-400 table mb-0 px-2" id="public-node-table">
                        <thead>
                            <tr>
                                <th class="dt-center">No Serial</th>
                                <th class="dt-center">Nama Node</th>
                                <th class="dt-center">Titik Lokasi</th>
                                <th class="dt-center">IoT Node</th>
                                <th class="dt-center">Tanggal Dibuat</th>
                                <th class="dt-center">Tangal Diupdate</th>
                                <th class="dt-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($pubNodes as $node)
                                <tr>
                                    <td>{{ $node->serial_number }}</td>
                                    <td class="whitespace-nowrap">{{ $node->name }}</td>
                                    <td class="flex flex-col">
                                        <span>Lat: {{ $node->latitude }}</span>
                                        <span>Lng: {{ $node->longitude }}</span>
                                    </td>
                                    <td>{{ $node->node->serial_number }}</td>
                                    <td>{{ $node->created_at }}</td>
                                    <td>{{ $node->updated_at }}</td>
                                    <td class="h-full">
                                        <div class="flex items-center justify-center gap-3 h-full">
                                            <a href="{{ route('public-node.edit', $node->id) }}" class="h-100">
                                                <i class="fa fa-pen text-primary"></i>
                                            </a>
                                            <form action="{{ route('public-node.destroy', $node->id) }}" method="POST"
                                                class="delete-form" data-serial="{{ $node->serial_number }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
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
                table = $('#public-node-table').DataTable({
                    responsive: true,
                    ordering: false,
                    dom: '<"dt-toolbar flex justify-between items-center bg-blue-500 px-4 py-2"Bf>rtp',
                    buttons: [{
                        extend: 'excel',
                        text: 'Export Excel',
                        title: 'Data Publik Node',
                        className: 'bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600',
                        filename: function() {
                            return `data_publik_node_${timestamp()}`;
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    }],
                    columnDefs: [{
                        className: "text-center",
                        targets: "_all"
                    }],
                    language: {
                        emptyTable: "Tidak ada data node yang tersedia",
                        paginate: {
                            previous: "<",
                            next: ">"
                        },
                        zeroRecords: "Data node tidak ditemukan.",
                        search: "" // kosongkan label "Search:"
                    }
                });

                $('#public-node-table_filter input').attr('placeholder', 'Cari Node...');
            });

            // Alert berhasil
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000,
                });
            @endif

            // Alert confirm delete
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    const serialNumber = this.getAttribute('data-serial');
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: `Apakah Anda yakin ingin menghapus data node dengan nomor serial ${serialNumber}?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                })
            });
        </script>
    @endpush
</x-app-layout>
