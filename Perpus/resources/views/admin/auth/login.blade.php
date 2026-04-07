<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-4 text-center">
        <h2 class="text-xl font-bold text-gray-800">Admin Login</h2>
    </div>

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>


        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-gray-900 underline flex items-center">
                &larr; Kembali ke Katalog
            </a>

            <div class="flex items-center justify-end">
                <x-primary-button class="ms-3">
                    {{ __('Log in as Admin') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>
