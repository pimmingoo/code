<x-layout title="Browse recipes">
    <x-slot name="header">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Browse recipes</h1>
        <p class="mt-1 text-sm text-gray-600">
            {{ $recipes->total() }} {{ Str::plural('recipe', $recipes->total()) }}
            @if ($activeTag)
                tagged <span class="font-medium text-orange-600">{{ $activeTag->name }}</span>
            @elseif ($search !== '')
                matching <span class="font-medium text-orange-600">"{{ $search }}"</span>
            @endif
        </p>
    </x-slot>

    {{-- Search + filters --}}
    <div class="mb-6 rounded-lg bg-white p-4 shadow-sm ring-1 ring-gray-200">
        <form method="GET" action="{{ route('recipes.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <svg class="pointer-events-none absolute top-2.5 left-3 size-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                </svg>
                <input type="search" name="q" value="{{ $search }}"
                    placeholder="Search recipes..."
                    class="w-full rounded-md border-gray-300 bg-white py-2 pr-3 pl-9 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500" />
            </div>
            @if ($activeTag)
                <input type="hidden" name="tag" value="{{ $activeTag->slug }}" />
            @endif
            <button type="submit"
                class="inline-flex items-center rounded-md bg-orange-500 px-3 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-600">
                Search
            </button>
            @if ($search !== '' || $activeTag)
                <a href="{{ route('recipes.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Clear</a>
            @endif
        </form>

        @if ($tags->isNotEmpty())
            <div class="mt-4 flex flex-wrap gap-2 border-t border-gray-100 pt-4">
                <a href="{{ route('recipes.index', ['q' => $search]) }}"
                    @class([
                        'inline-flex items-center rounded-full px-3 py-1 text-sm font-medium ring-1',
                        'bg-orange-100 text-orange-700 ring-orange-200' => ! $activeTag,
                        'bg-white text-gray-700 ring-gray-200 hover:bg-gray-50' => $activeTag,
                    ])>All</a>
                @foreach ($tags as $tag)
                    <a href="{{ route('recipes.index', ['tag' => $tag->slug, 'q' => $search]) }}"
                        @class([
                            'inline-flex items-center gap-1 rounded-full px-3 py-1 text-sm font-medium ring-1',
                            'bg-orange-100 text-orange-700 ring-orange-200' => $activeTag?->id === $tag->id,
                            'bg-white text-gray-700 ring-gray-200 hover:bg-gray-50' => $activeTag?->id !== $tag->id,
                        ])>
                        {{ $tag->name }}
                        <span class="text-xs text-gray-400">({{ $tag->recipes_count }})</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Results --}}
    @if ($recipes->isEmpty())
        <div class="rounded-lg border-2 border-dashed border-gray-300 p-12 text-center">
            <h3 class="text-sm font-semibold text-gray-900">No recipes found</h3>
            <p class="mt-1 text-sm text-gray-500">Try a different search or clear the filters.</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($recipes as $recipe)
                @include('recipes._card', ['recipe' => $recipe])
            @endforeach
        </div>

        <div class="mt-8">
            {{ $recipes->links() }}
        </div>
    @endif
</x-layout>
