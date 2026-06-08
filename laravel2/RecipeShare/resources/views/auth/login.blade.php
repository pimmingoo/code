<x-layout title="Sign in">
    <div class="mx-auto max-w-md">
        <div class="rounded-lg bg-white p-8 shadow-sm ring-1 ring-gray-200">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Sign in to your account</h1>
            <p class="mt-1 text-sm text-gray-600">
                New here?
                <a href="{{ route('register') }}" class="font-medium text-orange-600 hover:text-orange-500">Create an account</a>
            </p>

            <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                        value="{{ old('email') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('email') ring-red-500 @enderror" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('password') ring-red-500 @enderror" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="size-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500" />
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>

                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-orange-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500">
                    Sign in
                </button>
            </form>
        </div>
    </div>
</x-layout>
