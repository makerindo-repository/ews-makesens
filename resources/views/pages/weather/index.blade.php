<x-app-layout>
    <x-slot name="header">
        <h2 class="leading-tight">
            <ol class="breadcrumb">
                <li class="breadcrumb-item breadcrumb-active">
                    {{ __('Manajemen Data Cuaca') }}
                </li>
            </ol>
        </h2>
    </x-slot>

    <div class="pt-2 pb-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 flex flex-col gap-4">
            <h2 class="text-xl text-primary">
                <i class="fa-solid fa-cloud me-2"></i>
                Manajemen Data Cuaca
            </h2>

            <form action="{{ route('weather.store') }}" method="post" class="bg-white rounded-lg shadow p-4">
                @csrf
                <h3 class="text-lg mb-2">Pilih Wilayah Untuk Sumber Data Cuaca</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <x-input-label for="province">{{ __('Provinsi') }}</x-input-label>
                        <select id="province" class="block mt-1 w-full rounded-xl bg-gray-100" name="province"
                            required>
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->code }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('province')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="city">{{ __('Kabupaten/Kota') }}</x-input-label>
                        <select id="city" class="block mt-1 w-full rounded-xl bg-gray-100" name="city"
                            required></select>
                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="district">{{ __('Kecamatan') }}</x-input-label>
                        <select id="district" class="block mt-1 w-full rounded-xl bg-gray-100" name="district"
                            required></select>
                        <x-input-error :messages="$errors->get('district')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="village">{{ __('Desa') }}</x-input-label>
                        <select id="village" class="block mt-1 w-full rounded-xl bg-gray-100" name="village"
                            required></select>
                        <x-input-error :messages="$errors->get('village')" class="mt-2" />
                    </div>
                    <div class="md:col-span-2 mt-1 flex justify-end">
                        <div>
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
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

            $('#province').on('change', function() {
                let province_code = $(this).val();
                $.post('/weather/cities', {
                    province_code,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    console.log(province_code)
                    console.log(data)
                    $('#city').html('<option value="">-- Pilih Kota/Kabupaten --</option>');
                    data.forEach(city => {
                        $('#city').append(`<option value="${city.code}">${city.name}</option>`);
                    });
                });
            });

            $('#city').on('change', function() {
                let city_code = $(this).val();
                $.post('/weather/districts', {
                    city_code,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('#district').html('<option value="">-- Pilih Kecamatan --</option>');
                    data.forEach(d => {
                        $('#district').append(`<option value="${d.code}">${d.name}</option>`);
                    });
                });
            });

            $('#district').on('change', function() {
                let district_code = $(this).val();
                $.post('/weather/villages', {
                    district_code,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('#village').html('<option value="">-- Pilih Desa --</option>');
                    data.forEach(v => {
                        $('#village').append(`<option value="${v.code}">${v.name}</option>`);
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
