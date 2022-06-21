@props(['active'])

@php
$classes = $active ?? false ? 'text-white bg-gradient-to-r from-sky-600 to-cyan-400' : '';
@endphp

<li>
    <a aria-label="dashboard" {{ $attributes }}
        class="relative px-4 py-3 flex items-center space-x-4 rounded-xl hover:text-cyan-300 {{ $classes }}">
        <span class="-mr-1 font-medium">{{ $slot }}</span>
    </a>
</li>
