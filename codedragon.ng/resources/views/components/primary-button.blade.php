<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex justify-center items-center px-4 py-2 bg-gradient-to-r from-[#7C4DFF] to-[#9B70FF] border border-transparent rounded-xl font-bold text-[0.875rem] text-white tracking-wide hover:opacity-90 active:scale-95 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#7C4DFF] focus:ring-offset-2 focus:ring-offset-[#1e293b]']) }}>
    {{ $slot }}
</button>
