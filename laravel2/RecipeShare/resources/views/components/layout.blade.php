<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? config('app.name', 'RecipeShare') }}</title>

        @fonts

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="h-full">

        <div class="min-h-full">
            <nav class="bg-white border-b border-gray-200">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 items-center justify-between">

                        {{-- Logo + desktop nav --}}
                        <div class="flex items-center">
                            <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                                <svg class="size-7 text-orange-500" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/>
                                    <path d="M8.1 6.35A7.965 7.965 0 0 1 12 5c1.55 0 3 .44 4.22 1.21L14.5 8H9.5L8.1 6.35z"/>
                                </svg>
                                <span class="text-lg font-semibold text-gray-900">RecipeShare</span>
                            </a>
                            <div class="hidden md:block">
                                <div class="ml-8 flex items-baseline gap-1">
                                    <a href="{{ route('home') }}" @class(['rounded-md px-3 py-2 text-sm font-medium', 'bg-orange-50 text-orange-700' => request()->routeIs('home'), 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => ! request()->routeIs('home')])>
                                        Home
                                    </a>
                                    <a href="#" @class(['rounded-md px-3 py-2 text-sm font-medium', 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'])>
                                        Browse Recipes
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Desktop right side --}}
                        <div class="hidden md:flex items-center gap-3">
                            <a href="#" class="inline-flex items-center gap-1.5 rounded-md bg-orange-500 px-3 py-2 text-sm font-medium text-white hover:bg-orange-600">
                                <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                </svg>
                                Add Recipe
                            </a>

                            {{-- Profile dropdown --}}
                            <div class="relative" id="profile-menu">
                                <button onclick="document.getElementById('profile-dropdown').classList.toggle('hidden')" type="button" class="flex items-center gap-2 rounded-full focus:outline-2 focus:outline-offset-2 focus:outline-orange-500">
                                    <span class="sr-only">Open user menu</span>
                                    <span class="size-8 rounded-full bg-orange-100 flex items-center justify-center text-sm font-medium text-orange-700">
                                        {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'G' }}
                                    </span>
                                </button>
                                <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-48 rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 z-10">
                                    @auth
                                        <div class="px-4 py-2 text-xs text-gray-500 border-b border-gray-100">{{ auth()->user()->name }}</div>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">My Recipes</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                                        <form method="POST" action="#">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Sign out</button>
                                        </form>
                                    @else
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Sign in</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Register</a>
                                    @endauth
                                </div>
                            </div>
                        </div>

                        {{-- Mobile menu button --}}
                        <div class="-mr-2 flex md:hidden">
                            <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500">
                                <span class="sr-only">Open main menu</span>
                                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </button>
                        </div>

                    </div>
                </div>

                {{-- Mobile menu --}}
                <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200">
                    <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                        <a href="{{ route('home') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100">Home</a>
                        <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100">Browse Recipes</a>
                        <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100">Add Recipe</a>
                    </div>
                    <div class="border-t border-gray-200 pt-4 pb-3">
                        @auth
                            <div class="flex items-center px-5">
                                <span class="size-10 rounded-full bg-orange-100 flex items-center justify-center text-base font-medium text-orange-700">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                                <div class="ml-3">
                                    <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                                    <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                                </div>
                            </div>
                            <div class="mt-3 space-y-1 px-2">
                                <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-600 hover:bg-gray-100">My Recipes</a>
                                <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-600 hover:bg-gray-100">Profile</a>
                                <form method="POST" action="#">
                                    @csrf
                                    <button type="submit" class="w-full text-left rounded-md px-3 py-2 text-base font-medium text-gray-600 hover:bg-gray-100">Sign out</button>
                                </form>
                            </div>
                        @else
                            <div class="mt-3 space-y-1 px-2">
                                <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-600 hover:bg-gray-100">Sign in</a>
                                <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-600 hover:bg-gray-100">Register</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </nav>

            @isset($header)
                <header class="bg-white border-b border-gray-200">
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>

            <footer class="mt-auto border-t border-gray-200 bg-white">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <p class="text-center text-sm text-gray-500">&copy; {{ date('Y') }} RecipeShare. All rights reserved.</p>
                </div>
            </footer>
        </div>

        {{-- Close profile dropdown when clicking outside --}}
        <script>
            document.addEventListener('click', function (e) {
                const menu = document.getElementById('profile-menu');
                const dropdown = document.getElementById('profile-dropdown');
                if (menu && dropdown && !menu.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        </script>

    </body>
</html>
