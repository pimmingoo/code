<x-layout title="Add recipe">
    <x-slot name="header">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Add a recipe</h1>
        <p class="mt-1 text-sm text-gray-600">Share what you've been cooking.</p>
    </x-slot>

    <div class="mx-auto max-w-3xl">
        <form method="POST" action="{{ route('recipes.store') }}" enctype="multipart/form-data" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
            @csrf
            @include('recipes._form', ['submitLabel' => 'Publish recipe'])
        </form>
    </div>
</x-layout>
