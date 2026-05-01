<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Header --}}
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold" style="color: #042C53;">CASP Portal</h1>
        <p class="text-sm mt-1" style="color: #378ADD;">School Management System</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium mb-1" style="color: #042C53;">Email</label>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username"
                style="border: 1px solid #B5D4F4; border-radius: 8px; padding: 10px 12px; font-size: 14px; color: #042C53; background-color: #F4F7FB; width: 100%;" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <label for="password" class="block text-sm font-medium mb-1" style="color: #042C53;">Password</label>
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                required autocomplete="current-password"
                style="border: 1px solid #B5D4F4; border-radius: 8px; padding: 10px 12px; font-size: 14px; color: #042C53; background-color: #F4F7FB; width: 100%;" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember Me --}}
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    style="accent-color: #185FA5;">
                <span class="ms-2 text-sm" style="color: #185FA5;">Remember me</span>
            </label>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm underline"
                   style="color: #378ADD;"
                   onmouseover="this.style.color='#042C53'"
                   onmouseout="this.style.color='#378ADD'">
                    Forgot your password?
                </a>
            @endif

            <x-primary-button class="ms-3"
                style="background-color: #185FA5; border: none; padding: 10px 24px; border-radius: 8px; font-size: 14px; letter-spacing: 0.5px;"
                onmouseover="this.style.backgroundColor='#042C53'"
                onmouseout="this.style.backgroundColor='#185FA5'">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        {{-- Register Link --}}
        <div class="mt-5 text-center pt-4" style="border-top: 1px solid #B5D4F4;">
            <p class="text-sm" style="color: #185FA5;">
                Don't have an account yet?
                <a href="{{ route('register') }}"
                   class="font-semibold underline ms-1"
                   style="color: #042C53;"
                   onmouseover="this.style.color='#185FA5'"
                   onmouseout="this.style.color='#042C53'">
                    Register here
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>