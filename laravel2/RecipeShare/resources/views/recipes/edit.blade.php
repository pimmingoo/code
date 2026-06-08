<x-layout title="Edit recipe">
    <x-slot name="header">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Edit recipe</h1>
        <p class="mt-1 text-sm text-gray-600">{{ $recipe->title }}</p>
    </x-slot>

    <div class="mx-auto max-w-3xl">
        <form method="POST" action="{{ route('recipes.update', $recipe) }}" enctype="multipart/form-data" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
            @csrf
            @method('PATCH')
            @include('recipes._form', ['recipe' => $recipe, 'submitLabel' => 'Save changes'])
        </form>
    </div>
</x-layout>
