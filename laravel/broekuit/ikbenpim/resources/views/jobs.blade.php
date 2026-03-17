<x-layout>
    <x-slot:heading>
        Job page
    </x-slot:heading>

    @foreach ($jobs as $job)
        <li>
            <a href="/jobs/{{ $job['id'] }}" class="hover:underline">
                <strong>{{ $job['title'] }}</strong> - Pays: {{ $job['salary'] }} Per Year
            </a>
        </li>
    @endforeach
</x-layout>
