<x-layout :title="$recipe->title">
    @if (session('status') === 'recipe-created')
        <div class="mb-6 rounded-md bg-green-50 p-3 text-sm text-green-800 ring-1 ring-green-200">Recipe published.</div>
    @elseif (session('status') === 'recipe-updated')
        <div class="mb-6 rounded-md bg-green-50 p-3 text-sm text-green-800 ring-1 ring-green-200">Recipe updated.</div>
    @endif

    @php
        $isLiked = $recipe->isLikedBy(auth()->user());
        $isSaved = $recipe->isSavedBy(auth()->user());
    @endphp

    <article class="mx-auto max-w-3xl">
        @if ($recipe->image)
            <img src="{{ Storage::disk('public')->url($recipe->image) }}" alt="{{ $recipe->title }}" class="aspect-video w-full rounded-lg object-cover ring-1 ring-gray-200" />
        @endif

        <header class="mt-6">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $recipe->title }}</h1>
            <div class="mt-2 flex items-center gap-2 text-sm text-gray-600">
                <span>by {{ $recipe->user->name }}</span>
                <span aria-hidden="true">•</span>
                <span>{{ $recipe->created_at->format('M j, Y') }}</span>
            </div>

            @if ($recipe->tags->isNotEmpty())
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($recipe->tags as $tag)
                        <a href="{{ route('recipes.index', ['tag' => $tag->slug]) }}" class="inline-flex items-center rounded-full bg-orange-50 px-2.5 py-0.5 text-xs font-medium text-orange-700 ring-1 ring-orange-200 hover:bg-orange-100">{{ $tag->name }}</a>
                    @endforeach
                </div>
            @endif

            {{-- Action buttons --}}
            <div class="mt-4 flex flex-wrap items-center gap-2">
                @auth
                    {{-- Like --}}
                    <form method="POST" action="{{ route('recipes.like', $recipe) }}">
                        @csrf
                        <button type="submit"
                            @class([
                                'inline-flex items-center gap-1.5 rounded-md px-3 py-1.5 text-sm font-medium shadow-sm ring-1',
                                'bg-red-50 text-red-700 ring-red-200 hover:bg-red-100' => $isLiked,
                                'bg-white text-gray-700 ring-gray-300 hover:bg-gray-50' => ! $isLiked,
                            ])>
                            <svg class="size-4" viewBox="0 0 20 20" fill="{{ $isLiked ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.653 16.915l-.005-.003-.019-.01a20.8 20.8 0 0 1-1.162-.682 22.05 22.05 0 0 1-2.582-1.9C4.045 12.733 2 10.352 2 7.5a4.5 4.5 0 0 1 8-2.828A4.5 4.5 0 0 1 18 7.5c0 2.852-2.044 5.233-3.885 6.82a22.05 22.05 0 0 1-3.744 2.582l-.019.01-.005.003h-.002a.739.739 0 0 1-.69.001l-.002-.001Z" />
                            </svg>
                            <span>{{ $isLiked ? 'Liked' : 'Like' }}</span>
                            <span class="text-xs text-gray-500">{{ $recipe->likers_count }}</span>
                        </button>
                    </form>

                    {{-- Save --}}
                    <form method="POST" action="{{ route('recipes.save', $recipe) }}">
                        @csrf
                        <button type="submit"
                            @class([
                                'inline-flex items-center gap-1.5 rounded-md px-3 py-1.5 text-sm font-medium shadow-sm ring-1',
                                'bg-orange-50 text-orange-700 ring-orange-200 hover:bg-orange-100' => $isSaved,
                                'bg-white text-gray-700 ring-gray-300 hover:bg-gray-50' => ! $isSaved,
                            ])>
                            <svg class="size-4" viewBox="0 0 20 20" fill="{{ $isSaved ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 4.75a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2V17.5l-5-3-5 3V4.75Z" />
                            </svg>
                            <span>{{ $isSaved ? 'Saved' : 'Save' }}</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 rounded-md bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50">
                        Sign in to like &amp; save
                    </a>
                    <span class="text-sm text-gray-500">{{ $recipe->likers_count }} {{ Str::plural('like', $recipe->likers_count) }}</span>
                @endauth

                @auth
                    @php
                        $isOwner = $recipe->user_id === auth()->id();
                        $isAdmin = auth()->user()->isAdmin();
                    @endphp
                    @if ($isOwner || $isAdmin)
                        <span class="mx-2 h-5 w-px bg-gray-200" aria-hidden="true"></span>
                        @if ($isOwner)
                            <a href="{{ route('recipes.edit', $recipe) }}" class="inline-flex justify-center rounded-md bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50">Edit</a>
                        @endif
                        <form method="POST" action="{{ route('recipes.destroy', $recipe) }}" onsubmit="return confirm('Delete this recipe?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex justify-center rounded-md bg-white px-3 py-1.5 text-sm font-medium text-red-700 shadow-sm ring-1 ring-red-300 hover:bg-red-50">
                                <span>Delete</span>
                                @if (! $isOwner && $isAdmin)
                                    <span class="ml-1 text-xs font-normal text-red-500">(admin)</span>
                                @endif
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </header>

        <dl class="mt-6 grid grid-cols-3 gap-4 rounded-lg bg-white p-4 shadow-sm ring-1 ring-gray-200">
            <div class="text-center">
                <dt class="text-xs uppercase tracking-wide text-gray-500">Prep</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $recipe->prep_time }} min</dd>
            </div>
            <div class="text-center">
                <dt class="text-xs uppercase tracking-wide text-gray-500">Cook</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $recipe->cook_time }} min</dd>
            </div>
            <div class="text-center">
                <dt class="text-xs uppercase tracking-wide text-gray-500">Servings</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $recipe->servings }}</dd>
            </div>
        </dl>

        <section class="mt-8">
            <h2 class="text-lg font-semibold text-gray-900">Ingredients</h2>
            <ul class="mt-3 divide-y divide-gray-200 rounded-lg bg-white shadow-sm ring-1 ring-gray-200">
                @foreach ($recipe->ingredients as $ingredient)
                    <li class="flex items-center gap-3 px-4 py-2.5 text-sm">
                        <span class="w-24 text-gray-600">{{ $ingredient->amount }} {{ $ingredient->unit }}</span>
                        <span class="text-gray-900">{{ $ingredient->name }}</span>
                    </li>
                @endforeach
            </ul>
        </section>

        <section class="mt-8">
            <h2 class="text-lg font-semibold text-gray-900">Description</h2>
            <div class="mt-3 whitespace-pre-line text-sm leading-6 text-gray-700">{{ $recipe->description }}</div>
        </section>

        {{-- Comments --}}
        <section id="comments" class="mt-10">
            <h2 class="text-lg font-semibold text-gray-900">
                Comments
                <span class="text-sm font-normal text-gray-500">({{ $recipe->comments_count }})</span>
            </h2>

            @auth
                <form method="POST" action="{{ route('comments.store', $recipe) }}" class="mt-4 rounded-lg bg-white p-4 shadow-sm ring-1 ring-gray-200">
                    @csrf
                    <label for="body" class="sr-only">Your comment</label>
                    <textarea id="body" name="body" rows="3" required maxlength="2000"
                        placeholder="Share your thoughts..."
                        class="block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('body') ring-red-500 @enderror">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div class="mt-3 flex justify-end">
                        <button type="submit"
                            class="inline-flex justify-center rounded-md bg-orange-500 px-3 py-1.5 text-sm font-medium text-white shadow-sm hover:bg-orange-600">
                            Post comment
                        </button>
                    </div>
                </form>
            @else
                <p class="mt-4 text-sm text-gray-600">
                    <a href="{{ route('login') }}" class="font-medium text-orange-600 hover:text-orange-500">Sign in</a>
                    to leave a comment.
                </p>
            @endauth

            @if ($recipe->comments->isEmpty())
                <p class="mt-6 text-sm text-gray-500">No comments yet. Be the first to share your thoughts.</p>
            @else
                <ul class="mt-6 space-y-4">
                    @foreach ($recipe->comments->sortByDesc('created_at') as $comment)
                        <li class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-gray-200">
                            <div class="flex items-start gap-3">
                                @if ($comment->user->avatar)
                                    <img src="{{ Storage::disk('public')->url($comment->user->avatar) }}" alt="" class="size-9 rounded-full object-cover ring-1 ring-gray-200" />
                                @else
                                    <span class="size-9 rounded-full bg-orange-100 flex items-center justify-center text-sm font-medium text-orange-700">
                                        {{ strtoupper(substr($comment->user->first_name, 0, 1)) }}
                                    </span>
                                @endif
                                <div class="flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <div>
                                            <span class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</span>
                                            <span class="ml-1 text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        @auth
                                            @if ($comment->user_id === auth()->id() || auth()->user()->isAdmin())
                                                <form method="POST" action="{{ route('comments.destroy', $comment) }}" onsubmit="return confirm('Delete this comment?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-500">
                                                        <span>Delete</span>
                                                        @if ($comment->user_id !== auth()->id() && auth()->user()->isAdmin())
                                                            <span class="text-red-400">(admin)</span>
                                                        @endif
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                    <p class="mt-1 whitespace-pre-line text-sm text-gray-700">{{ $comment->body }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </article>
</x-layout>
