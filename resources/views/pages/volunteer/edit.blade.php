<x-app-layout>
    <x-slot name="header">
        <h2 class="leading-tight">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    {{ __('Data Master') }}
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('volunteer.index') }}">Data Relawan</a>
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
                <i class="fa-solid fa-user me-2"></i>
                Tambah Relawan
            </h2>

            <div class="flex justify-center items-center w-full">
                <div class="bg-white shadow-sm w-full md:w-5/6 lg:w-3/4 h-auto px-6 py-4 rounded-lg">
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold">Tambah Data Relawan</h3>
                        <p class="text-sm text-slate-500">Silakan isi semua informasi yang dibutuhkan</p>
                    </div>
                    <form action="{{ route('volunteer.update', $user->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="flex flex-col gap-3">
                            <div>
                                <x-input-label for="name">{{ __('Pilih Relawan') }}</x-input-label>
                                <select id="user_id" class="block mt-1 w-full rounded-xl bg-gray-100" name="user_id"
                                    disabled>
                                    <option value="">--- Pilih relawan ---</option>
                                    @foreach ($volunteers as $volunteer)
                                        <option value="{{ $volunteer->id }}" @selected($user->id == $volunteer->id)>{{ $volunteer->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="location">{{ __('Lokasi Tugas') }}</x-input-label>
                                <select id="location" class="block mt-1 w-full rounded-xl bg-gray-100" name="location"
                                    required>
                                    <option value="">--- Pilih lokasi ---</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}" @selected($user->location_id == $location->id)>{{ $location->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('volunteer.index') }}"
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
