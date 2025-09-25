<x-app-layout>
    <x-slot name="header">
        <h2 class="leading-tight">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('user.index') }}">Manajemen User</a>
                </li>
                <li class="breadcrumb-item breadcrumb-active">
                    {{ __('Tambah User') }}
                </li>
            </ol>
        </h2>
    </x-slot>

    <div class="pt-2 pb-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 flex flex-col gap-4">
            <h2 class="text-xl text-primary">
                <i class="fa-solid fa-users me-2"></i>
                Tambah User
            </h2>

            <div class="flex justify-center items-center w-full">
                <div class="bg-white shadow-sm w-full md:w-5/6 lg:w-3/4 h-auto px-6 py-4 rounded-lg">
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold">Tambah User</h3>
                        <p class="text-sm text-slate-500">Silakan isi semua informasi yang dibutuhkan</p>
                    </div>
                    <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="md:col-span-2">
                                <x-input-label for="profile_picture">{{ __('Foto Profil') }}</x-input-label>
                                <div class="mt-1">
                                    <div class="relative">
                                        <!-- Preview Container -->
                                        <div id="imagePreviewContainer"
                                            class="w-56 h-56 border-2 border-dashed border-gray-300 rounded-xl flex items-center justify-center cursor-pointer hover:border-gray-400 transition-colors">
                                            <div id="imagePreviewContent" class="text-center">
                                                <i class="fa-solid fa-cloud-upload-alt mx-auto text-5xl text-gray-400 mb-2"></i>
                                                <p class="mt-2 text-sm text-gray-600">Klik untuk memilih foto</p>
                                                <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                                            </div>
                                            <img id="imagePreview" class="hidden w-full h-full object-cover rounded-xl"
                                                alt="Preview">
                                        </div>

                                        <!-- Transparent File Input -->
                                        <input id="profile_picture"
                                            class="opacity-0 inset-0 absolute w-full h-full cursor-pointer"
                                            type="file" name="profile_picture" accept="image/*" required>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="name">{{ __('Nama Lengkap') }}</x-input-label>
                                <x-text-input id="name" class="block mt-1 w-full rounded-xl bg-gray-100"
                                    type="text" name="name" :value="old('name')" required autofocus
                                    autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="email">{{ __('Email') }}</x-input-label>
                                <x-text-input id="email" class="block mt-1 w-full rounded-xl bg-gray-100"
                                    type="email" name="email" :value="old('email')" required autofocus
                                    autocomplete="email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="block mt-1 w-full rounded-xl bg-gray-100"
                                    type="password" name="password" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                                <x-text-input id="password_confirmation"
                                    class="block mt-1 w-full rounded-xl bg-gray-100" type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="phone">{{ __('Nomor Telepon') }}</x-input-label>
                                <x-text-input id="phone" class="block mt-1 w-full rounded-xl bg-gray-100"
                                    type="tel" name="phone" :value="old('phone')" required autofocus
                                    autocomplete="phone" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label>{{ __('Jenis Kelamin') }}</x-input-label>
                                <div class="flex gap-3 mt-3">
                                    <x-input-label for="man">
                                        <input id="man" class="bg-gray-100" type="radio" name="gender"
                                            value="l" required autofocus autocomplete="gender" />
                                        {{ __('Laki-laki') }}
                                    </x-input-label>
                                    <x-input-label for="woman">
                                        <input id="woman" class="bg-gray-100" type="radio" name="gender"
                                            value="p" required autofocus autocomplete="gender" />
                                        {{ __('Perempuan') }}
                                    </x-input-label>
                                </div>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="address">{{ __('Alamat') }}</x-input-label>
                                <textarea name="address" id="address" class="block mt-1 w-full rounded-xl bg-gray-100" rows="3" required></textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2 flex items-center justify-end gap-3">
                                <a href="{{ route('iot-node.index') }}"
                                    class="bg-gray-200 text-slate-500 px-5 py-1.5 rounded-lg">Batal</a>
                                <button type="submit"
                                    class="bg-primary text-white px-5 py-1.5 rounded-lg">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            const fileInput = document.getElementById('profile_picture');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContent = document.getElementById('imagePreviewContent');

            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        imagePreviewContent.classList.add('hidden');
                    };

                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endpush
</x-app-layout>
