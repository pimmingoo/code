<x-layout title="Create account">
    <div class="mx-auto max-w-md">
        <div class="rounded-lg bg-white p-8 shadow-sm ring-1 ring-gray-200">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Create your account</h1>
            <p class="mt-1 text-sm text-gray-600">
                Already a member?
                <a href="{{ route('login') }}" class="font-medium text-orange-600 hover:text-orange-500">Sign in</a>
            </p>

            <form method="POST" action="{{ route('register.store') }}" class="mt-6 space-y-5">
                @csrf

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First name</label>
                        <input id="first_name" name="first_name" type="text" autocomplete="given-name" required
                            value="{{ old('first_name') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('first_name') ring-red-500 @enderror" />
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last name</label>
                        <input id="last_name" name="last_name" type="text" autocomplete="family-name" required
                            value="{{ old('last_name') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('last_name') ring-red-500 @enderror" />
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

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
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                        class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('password') ring-red-500 @enderror" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                        class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500" />
                </div>

                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-orange-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500">
                    Create account
                </button>
            </form>
        </div>
    </div>
</x-layout>
