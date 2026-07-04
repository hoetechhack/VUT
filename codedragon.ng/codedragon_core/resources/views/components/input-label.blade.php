@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#9A8FB5]']) }}>
    {{ $value ?? $slot }}
</label>
