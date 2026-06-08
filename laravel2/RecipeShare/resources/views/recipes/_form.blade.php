{{--
    Shared recipe form fields.
    Expects: $recipe (Recipe|null), $submitLabel (string)
--}}
@php
    $recipe ??= null;
    $existingIngredients = old('ingredients') ?? ($recipe?->ingredients->map(fn ($i) => [
        'name' => $i->name, 'amount' => $i->amount, 'unit' => $i->unit,
    ])->all() ?? [['name' => '', 'amount' => '', 'unit' => '']]);
    $tagsValue = old('tags', $recipe?->tags->pluck('name')->join(', ') ?? '');
@endphp

<div class="space-y-5">
    {{-- Title --}}
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
        <input id="title" name="title" type="text" required
            value="{{ old('title', $recipe?->title) }}"
            class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('title') ring-red-500 @enderror" />
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea id="description" name="description" rows="4" required
            class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('description') ring-red-500 @enderror">{{ old('description', $recipe?->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Image --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Image</label>
        <div class="mt-2 flex items-start gap-4">
            @if ($recipe?->image)
                <img src="{{ Storage::disk('public')->url($recipe->image) }}" alt="Current image" class="size-24 rounded-md object-cover ring-1 ring-gray-200" />
            @endif
            <div class="flex-1">
                <input id="image" name="image" type="file" accept="image/*"
                    class="block w-full text-sm text-gray-700 file:mr-3 file:rounded-md file:border-0 file:bg-orange-50 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-orange-700 hover:file:bg-orange-100" />
                <p class="mt-1 text-xs text-gray-500">Optional. PNG, JPG, or GIF. Max 4MB.</p>
                @if ($recipe?->image)
                    <label class="mt-2 inline-flex items-center text-sm text-gray-700">
                        <input type="checkbox" name="remove_image" value="1" class="mr-2 rounded border-gray-300 text-orange-600 focus:ring-orange-500" />
                        Remove current image
                    </label>
                @endif
            </div>
        </div>
        @error('image')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Times + servings --}}
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div>
            <label for="prep_time" class="block text-sm font-medium text-gray-700">Prep time (min)</label>
            <input id="prep_time" name="prep_time" type="number" min="0" max="1440" required
                value="{{ old('prep_time', $recipe?->prep_time) }}"
                class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('prep_time') ring-red-500 @enderror" />
            @error('prep_time')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="cook_time" class="block text-sm font-medium text-gray-700">Cook time (min)</label>
            <input id="cook_time" name="cook_time" type="number" min="0" max="1440" required
                value="{{ old('cook_time', $recipe?->cook_time) }}"
                class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('cook_time') ring-red-500 @enderror" />
            @error('cook_time')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="servings" class="block text-sm font-medium text-gray-700">Servings</label>
            <input id="servings" name="servings" type="number" min="1" max="100" required
                value="{{ old('servings', $recipe?->servings) }}"
                class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('servings') ring-red-500 @enderror" />
            @error('servings')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Ingredients --}}
    <div>
        <div class="flex items-center justify-between">
            <label class="block text-sm font-medium text-gray-700">Ingredients</label>
            <button type="button" onclick="addIngredient()" class="text-sm font-medium text-orange-600 hover:text-orange-500">+ Add ingredient</button>
        </div>
        <div id="ingredients-list" class="mt-2 space-y-2">
            @foreach ($existingIngredients as $i => $ingredient)
                <div class="grid grid-cols-12 gap-2 ingredient-row">
                    <input type="text" name="ingredients[{{ $i }}][amount]" placeholder="Amount" required
                        value="{{ $ingredient['amount'] }}"
                        class="col-span-3 rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500" />
                    <input type="text" name="ingredients[{{ $i }}][unit]" placeholder="Unit (e.g. g, tbsp)" required
                        value="{{ $ingredient['unit'] }}"
                        class="col-span-3 rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500" />
                    <input type="text" name="ingredients[{{ $i }}][name]" placeholder="Ingredient name" required
                        value="{{ $ingredient['name'] }}"
                        class="col-span-5 rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500" />
                    <button type="button" onclick="removeIngredient(this)" class="col-span-1 rounded-md text-sm text-red-600 hover:bg-red-50">×</button>
                </div>
            @endforeach
        </div>
        @error('ingredients')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        @foreach ($errors->get('ingredients.*') as $field => $messages)
            <p class="mt-1 text-sm text-red-600">{{ $messages[0] }}</p>
        @endforeach
    </div>

    {{-- Tags --}}
    <div>
        <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
        <input id="tags" name="tags" type="text"
            value="{{ $tagsValue }}"
            placeholder="dinner, vegan, italian"
            class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('tags') ring-red-500 @enderror" />
        <p class="mt-1 text-xs text-gray-500">Comma-separated. New tags will be created automatically.</p>
        @error('tags')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('recipes.my') }}" class="inline-flex justify-center rounded-md bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50">
            Cancel
        </a>
        <button type="submit"
            class="inline-flex justify-center rounded-md bg-orange-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500">
            {{ $submitLabel ?? 'Save' }}
        </button>
    </div>
</div>

<script>
    function addIngredient() {
        const list = document.getElementById('ingredients-list');
        const index = list.children.length;
        const row = document.createElement('div');
        row.className = 'grid grid-cols-12 gap-2 ingredient-row';
        row.innerHTML = `
            <input type="text" name="ingredients[${index}][amount]" placeholder="Amount" required class="col-span-3 rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500" />
            <input type="text" name="ingredients[${index}][unit]" placeholder="Unit (e.g. g, tbsp)" required class="col-span-3 rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500" />
            <input type="text" name="ingredients[${index}][name]" placeholder="Ingredient name" required class="col-span-5 rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500" />
            <button type="button" onclick="removeIngredient(this)" class="col-span-1 rounded-md text-sm text-red-600 hover:bg-red-50">×</button>
        `;
        list.appendChild(row);
    }

    function removeIngredient(button) {
        const list = document.getElementById('ingredients-list');
        if (list.children.length > 1) {
            button.closest('.ingredient-row').remove();
        }
    }
</script>
