<x-layout title="My recipes">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">My recipes</h1>
                <p class="mt-1 text-sm text-gray-600">{{ $recipes->count() }} {{ Str::plural('recipe', $recipes->count()) }}</p>
            </div>
            <a href="{{ route('recipes.create') }}" class="inline-flex items-center gap-1.5 rounded-md bg-orange-500 px-3 py-2 text-sm font-medium text-white hover:bg-orange-600">
                <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                </svg>
                Add Recipe
            </a>
        </div>
    </x-slot>

    @if (session('status') === 'recipe-deleted')
        <div class="mb-6 rounded-md bg-green-50 p-3 text-sm text-green-800 ring-1 ring-green-200">Recipe deleted.</div>
    @endif

    @if ($recipes->isEmpty())
        <div class="rounded-lg border-2 border-dashed border-gray-300 p-12 text-center">
            <h3 class="text-sm font-semibold text-gray-900">No recipes yet</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by creating your first recipe.</p>
            <a href="{{ route('recipes.create') }}" class="mt-4 inline-flex items-center gap-1.5 rounded-md bg-orange-500 px-3 py-2 text-sm font-medium text-white hover:bg-orange-600">
                Add Recipe
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($recipes as $recipe)
                <div>
                    @include('recipes._card', ['recipe' => $recipe, 'showAuthor' => false])
                    <div class="mt-2 flex items-center gap-2 px-1">
                        <a href="{{ route('recipes.edit', $recipe) }}" class="text-sm font-medium text-orange-600 hover:text-orange-500">Edit</a>
                        <span class="text-gray-300">|</span>
                        <form method="POST" action="{{ route('recipes.destroy', $recipe) }}" onsubmit="return confirm('Delete this recipe?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-500">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-layout>
