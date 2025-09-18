<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <p class="text-3xl font-bold text-[#0751A6]">Login</p>
            <p class="text-sm text-slate-500">Silakan masuk dengan akun Anda.</p>
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <div class="relative mt-1">
                <!-- Icon -->
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="fa-solid fa-envelope"></i>
                </span>

                <x-text-input id="email" class="block w-full pl-12" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" placeholder="email@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            {{-- 
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" /> --}}

            <div class="relative mt-1">
                <!-- Icon -->
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="fa-solid fa-key"></i>
                </span>

                <!-- Input -->
                <x-text-input id="password" class="block w-full pl-12 pr-10" type="password" name="password" required
                    autocomplete="current-password" placeholder="minimal 8 karakter" />

                <!-- Toggle visibility -->
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 cursor-pointer" id="togglePassword">
                    <i class="fa-solid fa-eye"></i>
                </span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center mt-4">
            <x-primary-button>
                {{ __('Login') }}
                <i class="fa-solid fa-arrow-right"></i>
            </x-primary-button>
        </div>
    </form>
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const toggle = document.querySelector("#togglePassword");
                const passwordInput = document.querySelector("#password");
                const icon = toggle.querySelector("i");

                toggle.addEventListener("click", () => {
                    const isPassword = passwordInput.type === "password";
                    passwordInput.type = isPassword ? "text" : "password";

                    // toggle icon
                    icon.classList.toggle("fa-eye");
                    icon.classList.toggle("fa-eye-slash");
                });
            });
        </script>
    @endpush
</x-guest-layout>
