<x-layout title="Profile">
    <x-slot name="header">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Profile</h1>
        <p class="mt-1 text-sm text-gray-600">Update your account details, avatar, and password.</p>
    </x-slot>

    @if (session('status') === 'profile-updated')
        <div class="mb-6 rounded-md bg-green-50 p-3 text-sm text-green-800 ring-1 ring-green-200">Profile updated.</div>
    @endif
    @if (session('status') === 'password-updated')
        <div class="mb-6 rounded-md bg-green-50 p-3 text-sm text-green-800 ring-1 ring-green-200">Password updated.</div>
    @endif

    <div class="space-y-8">
        {{-- Profile information --}}
        <section class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
            <header class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Profile information</h2>
                <p class="text-sm text-gray-600">Update your name, email, and avatar.</p>
            </header>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PATCH')

                {{-- Avatar --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Avatar</label>
                    <div class="mt-2 flex items-center gap-4">
                        @if ($user->avatar)
                            <img src="{{ Storage::disk('public')->url($user->avatar) }}" alt="Current avatar" class="size-16 rounded-full object-cover ring-1 ring-gray-200" />
                        @else
                            <span class="size-16 rounded-full bg-orange-100 flex items-center justify-center text-xl font-medium text-orange-700">
                                {{ strtoupper(substr($user->first_name, 0, 1)) }}
                            </span>
                        @endif
                        <div class="flex-1">
                            <input id="avatar" name="avatar" type="file" accept="image/*"
                                class="block w-full text-sm text-gray-700 file:mr-3 file:rounded-md file:border-0 file:bg-orange-50 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-orange-700 hover:file:bg-orange-100" />
                            <p class="mt-1 text-xs text-gray-500">PNG, JPG, or GIF. Max 2MB.</p>
                            @if ($user->avatar)
                                <label class="mt-2 inline-flex items-center text-sm text-gray-700">
                                    <input type="checkbox" name="remove_avatar" value="1" class="mr-2 rounded border-gray-300 text-orange-600 focus:ring-orange-500" />
                                    Remove current avatar
                                </label>
                            @endif
                        </div>
                    </div>
                    @error('avatar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First name</label>
                        <input id="first_name" name="first_name" type="text" autocomplete="given-name" required
                            value="{{ old('first_name', $user->first_name) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('first_name') ring-red-500 @enderror" />
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last name</label>
                        <input id="last_name" name="last_name" type="text" autocomplete="family-name" required
                            value="{{ old('last_name', $user->last_name) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('last_name') ring-red-500 @enderror" />
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                        value="{{ old('email', $user->email) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('email') ring-red-500 @enderror" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex justify-center rounded-md bg-orange-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500">
                        Save changes
                    </button>
                </div>
            </form>
        </section>

        {{-- Password --}}
        <section class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
            <header class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Update password</h2>
                <p class="text-sm text-gray-600">Choose a strong password you don't use elsewhere.</p>
            </header>

            <form method="POST" action="{{ route('profile.password') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current password</label>
                    <input id="current_password" name="current_password" type="password" autocomplete="current-password" required
                        class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('current_password') ring-red-500 @enderror" />
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">New password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                        class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500 @error('password') ring-red-500 @enderror" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm new password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                        class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm ring-1 ring-gray-300 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500" />
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex justify-center rounded-md bg-orange-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-2 focus:outline-offset-2 focus:outline-orange-500">
                        Update password
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-layout>
