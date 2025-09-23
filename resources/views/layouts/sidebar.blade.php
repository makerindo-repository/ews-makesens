<div>
    <div :class="{ 'block': sideopen, 'hidden': !sideopen }"
        class="flex flex-col bg-white w-64 lg:fixed lg:top-0 lg:bottom-0 lg:left-0 lg:ml-0 lg:mr-0 max-md:hidden overflow-y-scroll styled-scrollbars h-full"
        id="sidebar">
        <div id="app-brand" class="w-full h-16 mt-3 px-8">
            <a href="#" class="flex items-center" id="app-logo">
                <img src="{{ asset('images/logoMakesens.png') }}" alt="" srcset="" class="object-cover">
            </a>
        </div>
        <div class="flex-grow">
            <ul id="menu-inner"
                class="flex flex-col flex-auto items-start justify-start m-0 p-0 pt-6 relative overflow-hidden touch-auto pb-6">
                <li class="menu-item">
                    <a href="{{ route('dashboard') }}" @class([
                        'menu-link',
                        'active-icon' => request()->routeIs('dashboard'),
                    ])>
                        <i class="menu-icon fa-solid fa-house"></i>
                        <div class="text-base">Dashboard</div>
                    </a>
                </li>

                <!-- Group: Data & Monitoring -->
                <li class="mt-6 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    Data & Monitoring
                </li>

                <li x-data="{ open: false }" class="menu-item w-full">
                    <button @click="open = !open" :aria-expanded="open"
                        class="menu-link w-full flex items-center pe-10 py-2 text-left">
                        <i class="menu-icon fa-solid fa-database"></i>
                        <div class="text-base flex-1">Data Master</div>
                        <i class="fa-solid fa-chevron-down ml-2 transition-transform duration-200"
                            :class="{ 'rotate-180': open }"></i>
                    </button>

                    <!-- submenu -->
                    <ul x-show="open" x-cloak class="ml-8 mt-1 space-y-1"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-125"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1">
                        <li>
                            <a href="{{ route('iot-node.index') }}" class="menu-link">
                                <div class="text-sm"><span class="me-2">--</span> Data IoT Node</div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="menu-link">
                                <div class="text-sm"><span class="me-2">--</span> Data Publik Node</div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="menu-link">
                                <div class="text-sm"><span class="me-2">--</span> Data Lokasi</div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="menu-link">
                                <div class="text-sm"><span class="me-2">--</span> Data Relawan</div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="menu-link">
                                <div class="text-sm"><span class="me-2">--</span> Data Raw</div>
                            </a>
                        </li>
                        <!-- tambahkan submenu lain di sini -->
                    </ul>
                </li>

                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="menu-icon fa-solid fa-clipboard"></i>
                        <div class="text-base">Laporan</div>
                    </a>
                </li>

                <!-- Group: Konfigurasi -->
                <li class="mt-6 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    Konfigurasi
                </li>

                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="menu-icon fa-solid fa-users"></i>
                        <div class="text-base">Manajemen User</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="menu-icon fa-solid fa-key"></i>
                        <div class="text-base">Manajemen API</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="menu-icon fa-solid fa-gear"></i>
                        <div class="text-base">Pengaturan</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="menu-icon fa-solid fa-clock-rotate-left"></i>
                        <div class="text-base">Log Aktivitas</div>
                    </a>
                </li>
            </ul>
        </div>
        <div id="menu-footer" class="mb-3 text-center font-normal text-sm text-slate-500"></div>
    </div>
</div>
