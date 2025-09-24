<x-app-layout>
    <x-slot name="header">
        <h2 class="leading-tight">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    {{ __('Data Master') }}
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('iot-node.index') }}">IoT Node</a>
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
                Tambah IoT Node
            </h2>

            <div class="flex justify-center items-center w-full">
                <div class="bg-white shadow-sm w-full md:w-5/6 lg:w-3/4 h-auto px-6 py-4 rounded-lg">
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold">Tambah Data IoT Node</h3>
                        <p class="text-sm text-slate-500">Silakan isi semua informasi yang dibutuhkan</p>
                    </div>
                    <form action="{{ route('iot-node.store') }}" method="post">
                        @csrf
                        <div class="flex flex-col gap-3">
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
                                <x-input-label for="location">{{ __('Lokasi') }}</x-input-label>
                                <select id="location" class="block mt-1 w-full rounded-xl bg-gray-100" name="location"
                                    required>
                                    <option value="">--- Pilih lokasi ---</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>
                            <div class="flex items-center justify-end gap-3">
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
</x-app-layout>
