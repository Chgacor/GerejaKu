@props(['href', 'active' => false])

@php
    $classes = $active
                ? 'text-blue-600 font-bold'
                : 'text-gray-600';
    $underlineClasses = $active
                ? 'scale-x-100'
                : 'scale-x-0 group-hover:scale-x-100';
@endphp

<div class="relative group">
    <a href="{{ $href }}" class="{{ $classes }} hover:text-blue-600 transition-colors duration-300 py-2">
        {{ $slot }}
    </a>
    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-500 transform {{ $underlineClasses }} transition-transform duration-300 ease-out origin-left"></span>
</div>
