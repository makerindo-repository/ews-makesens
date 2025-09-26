<x-app-layout>
    <x-slot name="header">
        <h2 class="leading-tight">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    {{ __('Pengaturan') }}
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('threshold.index') }}">Pengaturan Threshold</a>
                </li>
                <li class="breadcrumb-item breadcrumb-active">
                    {{ __('Edit Data') }}
                </li>
            </ol>
        </h2>
    </x-slot>

    <div class="pt-2 pb-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 flex flex-col gap-4">
            <h2 class="text-xl text-primary">
                <i class="fa-solid fa-gear me-2"></i>
                Edit Threshold
            </h2>

            <div class="flex justify-center items-center w-full">
                <div class="bg-white shadow-sm w-full md:w-5/6 lg:w-3/4 h-auto px-6 py-4 rounded-lg">
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold">Edit Data Threshold</h3>
                        <p class="text-sm text-slate-500">Silakan isi semua informasi yang dibutuhkan</p>
                    </div>
                    <form action="{{ route('threshold.update', $threshold->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="grid md:grid-cols-2 gap-3">
                            <div>
                                <x-input-label for="iot_node">{{ __('IoT Node') }}</x-input-label>
                                <select id="iot_node" class="block mt-1 w-full rounded-xl bg-gray-100" name="iot_node"
                                    required disabled>
                                    <option value="">--- Pilih node ---</option>
                                    @foreach ($iotNodes as $node)
                                        <option value="{{ $node->id }}" @selected($node->id == $threshold->iot_node_id)>{{ $node->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('iot_node')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="waspada">{{ __('Waspada') }}</x-input-label>
                                <x-text-input id="waspada" class="block mt-1 w-full rounded-xl bg-gray-100"
                                    type="number" name="waspada" :value="$threshold->waspada" min="0" required autofocus
                                    autocomplete="waspada"/>
                                <x-input-error :messages="$errors->get('waspada')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="siaga">{{ __('Siaga') }}</x-input-label>
                                <x-text-input id="siaga" class="block mt-1 w-full rounded-xl bg-gray-100"
                                    type="number" name="siaga" :value="$threshold->siaga" min="0" required autofocus
                                    autocomplete="siaga"/>
                                <x-input-error :messages="$errors->get('siaga')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="awas">{{ __('Awas') }}</x-input-label>
                                <x-text-input id="awas" class="block mt-1 w-full rounded-xl bg-gray-100"
                                    type="number" name="awas" :value="$threshold->awas" min="0" required autofocus
                                    autocomplete="awas"/>
                                <x-input-error :messages="$errors->get('awas')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="h2">{{ __('h2 (Tinggi dari daratan ke dasar sungai)') }}</x-input-label>
                                <x-text-input id="h2" class="block mt-1 w-full rounded-xl bg-gray-100"
                                    type="number" name="h2" :value="$threshold->h2" min="0" required autofocus
                                    autocomplete="h2"/>
                                <x-input-error :messages="$errors->get('h2')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="h1">{{ __('h1 (Tinggi muka sensor terhadap daratan)') }}</x-input-label>
                                <x-text-input id="h1" class="block mt-1 w-full rounded-xl bg-gray-100"
                                    type="number" name="h1" :value="$threshold->h1" min="0" required autofocus
                                    autocomplete="h1"/>
                                <x-input-error :messages="$errors->get('h1')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2 flex justify-end items-center gap-3">
                                <a href="{{ route('threshold.index') }}"
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
