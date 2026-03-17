@props(['active' => false, 'type' => 'a'])

<!-- @if ($type == 'a') -->
    <a
        class="{{ $active ? 'bg-gray-700 p-2 font-semibold rounded-xl text-white' : 'p-2 font-semibold text-white' }}"
        aria-current="{{ $active ? 'page' : 'false' }}"
        {{ $attributes }}
        >
            {{ $slot }}
    </a>
<!-- 
@else 
    <button
        class="{{ $active ? 'bg-gray-700 p-2 font-semibold rounded-xl text-white' : 'p-2 font-semibold text-white' }}"
        aria-current="{{ $active ? 'page' : 'false' }}"
        {{ $attributes }}
        >
            {{ $slot }}
    </button>
@endif -->