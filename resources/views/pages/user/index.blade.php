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
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Manajemen User') }}
        </h2>
    </x-slot>

    <div class="pt-2 pb-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 flex flex-col gap-4">
            <h2 class="text-xl text-primary">
                <i class="fa-solid fa-users me-2"></i>
                Manajemen User
            </h2>

            <a href="{{ route('user.create') }}"
                class="bg-primary text-white w-auto ms-auto rounded-lg py-2 px-3 flex justify-between items-center gap-2">
                <i class="fa-solid fa-circle-plus"></i>
                Tambah user
            </a>
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="overflow-x-scroll">
                    <table class="w-full align-middle border-slate-400 table mb-0 px-2" id="user-table">
                        <thead>
                            <tr>
                                <th class="dt-center">No</th>
                                <th class="dt-center">Nama</th>
                                <th class="dt-center">Email</th>
                                <th class="dt-center">Nomor Telepon</th>
                                <th class="dt-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td class="h-full">
                                        <div class="flex items-center justify-center gap-3 h-full">
                                            <button class="openModalBtn h-100" data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}" data-phone="{{ $user->phone }}"
                                                data-gender="{{ $user->gender }}" data-address="{{ $user->address }}"
                                                data-photo="{{ $user->profile_picture ?? asset('images/profile-picture/embung.jpg') }}">
                                                <i class="fa-solid fa-circle-info text-yellow-500"></i>
                                            </button>
                                            <a href="{{ route('user.edit', $user->id) }}" class="h-100">
                                                <i class="fa-solid fa-pen text-primary"></i>
                                            </a>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                class="delete-form" data-name="{{ $user->serial_number }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">
                                                    <i class="fa-solid fa-trash text-danger"></i>
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

            <!-- Modal Detail -->
            <div id="detailModal"
                class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center z-50 hidden">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">

                    <!-- Header -->
                    <div class="flex items-center gap-2 border-b pb-2 mb-4">
                        <i class="fa-solid fa-user text-blue-500"></i>
                        <h2 class="text-lg font-semibold text-gray-700">Detail User</h2>
                    </div>

                    <!-- Body -->
                    <div class="flex flex-col items-center">
                        <!-- Foto -->
                        <img id="detailPhoto" src="{{ asset('images/profile-picture/embung.jpg') }}" alt="User Photo"
                            class="w-32 h-32 rounded-full mb-4 object-cover">

                        <div class="w-full text-sm space-y-1">
                            <div class="table w-full border-separate border-spacing-y-2">
                                <div class="table-row">
                                    <div class="table-cell text-gray-500">Nama Lengkap</div>
                                    <div class="table-cell w-1 px-2">:</div>
                                    <div class="table-cell font-medium text-gray-700" id="detailName">Ahmad Agung</div>
                                </div>
                                <div class="table-row">
                                    <div class="table-cell text-gray-500">Email</div>
                                    <div class="table-cell w-1 px-2">:</div>
                                    <div class="table-cell font-medium text-gray-700" id="detailEmail">
                                        ahmadagung@gmail.com</div>
                                </div>
                                <div class="table-row">
                                    <div class="table-cell text-gray-500">No HP / Whatsapp</div>
                                    <div class="table-cell w-1 px-2">:</div>
                                    <div class="table-cell font-medium text-gray-700" id="detailPhone">08516273874</div>
                                </div>
                                <div class="table-row">
                                    <div class="table-cell text-gray-500">Jenis Kelamin</div>
                                    <div class="table-cell w-1 px-2">:</div>
                                    <div class="table-cell font-medium text-gray-700" id="detailGender">Laki-laki</div>
                                </div>
                                <div class="table-row">
                                    <div class="table-cell text-gray-500">Alamat</div>
                                    <div class="table-cell w-1 px-2">:</div>
                                    <div class="table-cell font-medium text-gray-700" id="detailAddress">Cibiru, Kota
                                        Bandung</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-center mt-6">
                        <button id="closeModalBtn"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md px-6 py-2">
                            Kembali
                        </button>
                    </div>
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
                table = $('#user-table').DataTable({
                    responsive: true,
                    ordering: false,
                    dom: '<"dt-toolbar flex justify-between items-center bg-blue-500 px-4 py-2"Bf>rtp',
                    buttons: [{
                        extend: 'excel',
                        text: 'Export Excel',
                        title: 'Data IoT user',
                        className: 'bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600',
                        filename: function() {
                            return `data_user_${timestamp()}`;
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    }],
                    columnDefs: [{
                        className: "text-center",
                        targets: "_all"
                    }],
                    language: {
                        emptyTable: "Tidak ada data user yang tersedia",
                        paginate: {
                            previous: "<",
                            next: ">"
                        },
                        zeroRecords: "Data user tidak ditemukan.",
                        search: "" // kosongkan label "Search:"
                    }
                });

                $('#user-table_filter input').attr('placeholder', 'Cari user...');
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

                    const userName = this.getAttribute('data-name');
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: `Apakah Anda yakin ingin menghapus data user bernama ${userName}?`,
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

            document.addEventListener("DOMContentLoaded", function() {
                // Open Detail Modal
                const openModalBtn = document.querySelectorAll('.openModalBtn');
                const closeModalBtn = document.getElementById('closeModalBtn');
                const modal = document.getElementById('detailModal');

                openModalBtn.forEach(btn => {
                    btn.addEventListener('click', () => {
                        // ambil data dari atribut tombol
                        const name = btn.dataset.name;
                        const email = btn.dataset.email;
                        const phone = btn.dataset.phone;
                        const gender = btn.dataset.gender;
                        const address = btn.dataset.address;
                        const photo = btn.dataset.photo;

                        // isi modal
                        document.getElementById('detailName').textContent = name;
                        document.getElementById('detailEmail').textContent = email;
                        document.getElementById('detailPhone').textContent = phone;
                        document.getElementById('detailGender').textContent = gender === 'l' ?
                            'Laki-laki' : 'Perempuan';
                        document.getElementById('detailAddress').textContent = address;
                        document.getElementById('detailPhoto').src = photo;

                        // tampilkan modal
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    });
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
