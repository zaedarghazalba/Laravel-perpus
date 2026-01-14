<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 font-display">Welcome Back!</h2>
        <p class="text-gray-500 text-sm mt-1">Please sign in to your account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="john@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-brand-600 hover:text-brand-500 hover:underline" href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me + Submit -->
        <div class="flex items-center justify-between pt-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-500 cursor-pointer" name="remember">
                <span class="ms-2 text-sm text-gray-600 select-none">{{ __('Remember me') }}</span>
            </label>
        </div>

        <x-primary-button class="w-full">
            {{ __('Sign In') }}
        </x-primary-button>
        
        <div class="mt-6 text-center text-sm text-gray-500">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-semibold text-brand-600 hover:text-brand-500 hover:underline">
                Sign up
            </a>
        </div>
    </form>
</x-guest-layout>
