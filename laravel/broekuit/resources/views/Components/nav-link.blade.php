@props(['active' => false])

<a
   class="{{ $active ? 'bg-gray-700 p-2 font-semibold rounded-xl text-white' : 'p-2 font-semibold text-white' }}"
   aria-current="{{ $active ? 'page' : 'false' }}"
   {{ $attributes }}
>
    {{ $slot }}
</a>
