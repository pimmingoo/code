<x-layout title="Welcome to RecipeShare">
    {{-- Hero --}}
    <section class="mb-12 overflow-hidden rounded-2xl bg-gradient-to-br from-orange-500 to-amber-500 px-6 py-12 sm:px-10 sm:py-16">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">
                Cook, share, discover
            </h1>
            <p class="mt-4 text-base text-orange-50 sm:text-lg">
                Find your next favourite meal and share your own kitchen wins with the RecipeShare community.
            </p>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('recipes.index') }}"
                    class="inline-flex items-center gap-1.5 rounded-md bg-white px-4 py-2 text-sm font-medium text-orange-700 shadow-sm hover:bg-orange-50">
                    Browse recipes
                </a>
                @auth
                    <a href="{{ route('recipes.create') }}"
                        class="inline-flex items-center gap-1.5 rounded-md bg-orange-700 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-800">
                        Add a recipe
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center gap-1.5 rounded-md bg-orange-700 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-800">
                        Join RecipeShare
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- Popular tags --}}
    @if ($popularTags->isNotEmpty())
        <section class="mb-10">
            <h2 class="mb-3 text-lg font-semibold text-gray-900">Popular tags</h2>
            <div class="flex flex-wrap gap-2">
                @foreach ($popularTags as $tag)
                    <a href="{{ route('recipes.index', ['tag' => $tag->slug]) }}"
                        class="inline-flex items-center gap-1 rounded-full bg-white px-3 py-1 text-sm font-medium text-gray-700 ring-1 ring-gray-200 hover:bg-orange-50 hover:text-orange-700 hover:ring-orange-200">
                        {{ $tag->name }}
                        <span class="text-xs text-gray-400">({{ $tag->recipes_count }})</span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Latest recipes --}}
    <section>
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Latest recipes</h2>
            <a href="{{ route('recipes.index') }}" class="text-sm font-medium text-orange-600 hover:text-orange-500">View all →</a>
        </div>

        @if ($latestRecipes->isEmpty())
            <div class="rounded-lg border-2 border-dashed border-gray-300 p-12 text-center">
                <h3 class="text-sm font-semibold text-gray-900">No recipes yet</h3>
                <p class="mt-1 text-sm text-gray-500">Be the first to share something delicious.</p>
                @auth
                    <a href="{{ route('recipes.create') }}" class="mt-4 inline-flex items-center gap-1.5 rounded-md bg-orange-500 px-3 py-2 text-sm font-medium text-white hover:bg-orange-600">
                        Add Recipe
                    </a>
                @else
                    <a href="{{ route('register') }}" class="mt-4 inline-flex items-center gap-1.5 rounded-md bg-orange-500 px-3 py-2 text-sm font-medium text-white hover:bg-orange-600">
                        Get started
                    </a>
                @endauth
            </div>
        @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($latestRecipes as $recipe)
                    @include('recipes._card', ['recipe' => $recipe])
                @endforeach
            </div>
        @endif
    </section>
</x-layout>
