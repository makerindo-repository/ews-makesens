<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full text-center px-4 py-2 bg-[#2185C7] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#0751A6] focus:bg-[#0751A6] active:bg-[#0751A6] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
