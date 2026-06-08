{{-- Expects: $recipe (Recipe with user loaded), $showAuthor (bool, default true) --}}
@php($showAuthor ??= true)

<article class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-200 transition hover:shadow-md">
    <a href="{{ route('recipes.show', $recipe) }}" class="block">
        @if ($recipe->image)
            <img src="{{ Storage::disk('public')->url($recipe->image) }}" alt="{{ $recipe->title }}" class="aspect-video w-full object-cover" />
        @else
            <div class="aspect-video w-full bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                <svg class="size-12 text-orange-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z" />
                </svg>
            </div>
        @endif
    </a>
    <div class="p-4">
        <a href="{{ route('recipes.show', $recipe) }}" class="block">
            <h3 class="text-lg font-semibold text-gray-900 hover:text-orange-600">{{ $recipe->title }}</h3>
        </a>
        @if ($showAuthor && $recipe->relationLoaded('user') && $recipe->user)
            <p class="mt-1 text-xs text-gray-500">by {{ $recipe->user->name }}</p>
        @endif
        <div class="mt-2 flex items-center gap-3 text-xs text-gray-500">
            <span>{{ $recipe->prep_time + $recipe->cook_time }} min</span>
            <span aria-hidden="true">•</span>
            <span>{{ $recipe->servings }} {{ Str::plural('serving', $recipe->servings) }}</span>
            @isset($recipe->ingredients_count)
                <span aria-hidden="true">•</span>
                <span>{{ $recipe->ingredients_count }} {{ Str::plural('ingredient', $recipe->ingredients_count) }}</span>
            @endisset
        </div>
    </div>
</article>
