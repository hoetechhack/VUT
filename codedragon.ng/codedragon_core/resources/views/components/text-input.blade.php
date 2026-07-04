@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-[#101018] text-[#f8fafc] border-[#334155] focus:border-[#7C4DFF] focus:ring-[#7C4DFF] rounded-lg shadow-sm placeholder-[#64748b] w-full']) }}>
