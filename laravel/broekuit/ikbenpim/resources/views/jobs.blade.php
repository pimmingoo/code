<x-layout>
    <x-slot:heading>
        Job page
    </x-slot:heading>

    <div class="space-y-4">
    @foreach ($jobs as $job)
        <a href="/jobs/{{ $job['id'] }}" class="block px-4 py-6 border-2 border-gray-500 rounded-lg hover:border-opacity-25">
            <div class="font-bold text-blue-500 text-sm">
                {{ $job->employer->name }}
            </div>
            <div>
                <strong>{{ $job['title'] }}</strong> - Pays: {{ $job['salary'] }} Per Year
            </div>
        </a>
    @endforeach
    </div>
</x-layout>