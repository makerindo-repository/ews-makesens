<x-app-layout>
    <x-slot name="header">
        <h2 class="leading-tight">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    {{ __('Pengaturan') }}
                </li>
                <li class="breadcrumb-item breadcrumb-active">
                    {{ __('Pengaturan Aplikasi') }}
                </li>
            </ol>
        </h2>
    </x-slot>

    <div class="pt-2 pb-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 flex flex-col gap-4">
            <h2 class="text-xl text-primary">
                <i class="fa-solid fa-gear me-2"></i>
                Pengaturan Aplikasi
            </h2>

            <form action="{{ route('app-setting.store') }}" method="post">
                @csrf
                <div class="grid md:grid-cols-3 gap-3">
                    <div class="bg-white shadow-sm rounded-lg p-4 flex flex-col gap-3">
                        <p class="font-medium text-gray-700">
                            <i class="fa-solid fa-laptop text-primary mr-2"></i> Logo Website
                        </p>

                        <!-- Preview / Placeholder -->
                        <div class="border rounded-lg w-56 h-56 flex items-center justify-center bg-gray-50">
                            <span id="logoPlaceholder" class="text-gray-400 text-sm text-center px-2">
                                Foto max 2MB<br>format JPG/PNG
                            </span>
                            <img id="logoPreview" src="" alt="Logo Website"
                                class="hidden object-contain w-full h-full">
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-2 justify-between">
                            <input type="file" id="logoInput" name="logo" accept="image/*" class="hidden">

                            <button type="button"
                                class="px-3 py-2 bg-blue-500 text-white text-sm rounded-lg shadow hover:bg-blue-600 transition"
                                onclick="document.getElementById('logoInput').click()">
                                <i class="fa-solid fa-upload mr-1"></i> Upload Baru
                            </button>

                            <button type="button"
                                class="px-3 py-2 bg-gray-100 text-danger text-sm rounded-lg shadow hover:bg-gray-200 transition"
                                onclick="clearLogo()">
                                <i class="fa-solid fa-trash mr-1"></i> Hapus Logo
                            </button>
                        </div>
                    </div>
                    <div class="bg-white shadow-sm rounded-lg p-4 md:col-span-2 flex flex-col gap-3">
                        <p><i class="fa-solid fa-laptop text-primary me-2"></i> Informasi Website</p>
                        <div class="grid md:grid-cols-2 gap-3">
                            <div>
                                <x-input-label for="name">{{ __('Nama Website') }}</x-input-label>
                                <x-text-input id="name" class="block mt-1 w-full rounded-xl bg-gray-100"
                                    type="text" name="name" :value="old('name', $setting->name ?? '')" required autofocus
                                    autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tab_name">{{ __('Nama Tab Browser') }}</x-input-label>
                                <x-text-input id="tab_name" class="block mt-1 w-full rounded-xl bg-gray-100"
                                    type="text" name="tab_name" :value="old('tab_name', $setting->tab_name ?? '')" required autofocus
                                    autocomplete="tab_name" />
                                <x-input-error :messages="$errors->get('tab_name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="version">{{ __('Versi') }}</x-input-label>
                                <x-text-input id="version" class="block mt-1 w-full rounded-xl bg-gray-100"
                                    type="text" name="version" :value="old('version', $setting->version ?? '')" required autocomplete="version" />
                                <x-input-error :messages="$errors->get('version')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="copyright">{{ __('Copyright') }}</x-input-label>
                                <x-text-input id="copyright" class="block mt-1 w-full rounded-xl bg-gray-100"
                                    type="text" name="copyright" :value="old('copyright', $setting->copyright ?? '')" required
                                    autocomplete="copyright" />
                                <x-input-error :messages="$errors->get('copyright')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="copyright_year">{{ __('Tahun Copyright') }}</x-input-label>
                                <x-text-input id="copyright_year" class="block mt-1 w-full rounded-xl bg-gray-100"
                                    type="text" name="copyright_year" :value="old('copyright_year', $setting->copyright_year ?? '')" required
                                    autocomplete="copyright_year" />
                                <x-input-error :messages="$errors->get('copyright_year')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2 mt-1 flex justify-end">
                                <div>
                                    <x-primary-button>
                                        {{ __('Simpan') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
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

            // Handle input logo
            const logoInput = document.getElementById('logoInput');
            const logoPreview = document.getElementById('logoPreview');
            const logoPlaceholder = document.getElementById('logoPlaceholder');

            logoInput.addEventListener('change', (e) => {
                if (e.target.files && e.target.files[0]) {
                    const file = e.target.files[0];

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        logoPreview.src = e.target.result;
                        logoPreview.classList.remove('hidden');
                        logoPlaceholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });

            function clearLogo() {
                logoInput.value = ""; // reset input
                logoPreview.src = "";
                logoPreview.classList.add('hidden');
                logoPlaceholder.classList.remove('hidden');
            }
        </script>
    @endpush
</x-app-layout>
