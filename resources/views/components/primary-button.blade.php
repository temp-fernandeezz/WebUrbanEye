<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#00261a] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#E3B873] focus:bg-[#E3B873] active:bg-[#E3B873] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
