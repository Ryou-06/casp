<x-guest-layout>

    {{-- Header --}}
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold" style="color: #042C53;">CASP Portal</h1>
        <p class="text-sm mt-1" style="color: #378ADD;">Create your account</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-medium mb-1" style="color: #042C53;">Name</label>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                :value="old('name')" required autofocus autocomplete="name"
                style="border: 1px solid #B5D4F4; border-radius: 8px; padding: 10px 12px; font-size: 14px; color: #042C53; background-color: #F4F7FB; width: 100%;" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div class="mt-4">
            <label for="email" class="block text-sm font-medium mb-1" style="color: #042C53;">Email</label>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                :value="old('email')" required autocomplete="username"
                style="border: 1px solid #B5D4F4; border-radius: 8px; padding: 10px 12px; font-size: 14px; color: #042C53; background-color: #F4F7FB; width: 100%;" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <label for="password" class="block text-sm font-medium mb-1" style="color: #042C53;">Password</label>
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                required autocomplete="new-password"
                style="border: 1px solid #B5D4F4; border-radius: 8px; padding: 10px 12px; font-size: 14px; color: #042C53; background-color: #F4F7FB; width: 100%;" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div class="mt-4">
            <label for="password_confirmation" class="block text-sm font-medium mb-1" style="color: #042C53;">Confirm Password</label>
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password"
                style="border: 1px solid #B5D4F4; border-radius: 8px; padding: 10px 12px; font-size: 14px; color: #042C53; background-color: #F4F7FB; width: 100%;" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Role --}}
        <div class="mt-4">
            <label for="role" class="block text-sm font-medium mb-1" style="color: #042C53;">Register as</label>
            <select id="role" name="role" required
                style="border: 1px solid #B5D4F4; border-radius: 8px; padding: 10px 12px; font-size: 14px; color: #042C53; background-color: #F4F7FB; width: 100%;">
                <option value="" disabled selected>-- Select Role --</option>
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end mt-6">
            <x-primary-button
                style="background-color: #185FA5; border: none; padding: 10px 24px; border-radius: 8px; font-size: 14px; letter-spacing: 0.5px;"
                onmouseover="this.style.backgroundColor='#042C53'"
                onmouseout="this.style.backgroundColor='#185FA5'">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        {{-- Login Link --}}
        <div class="mt-5 text-center pt-4" style="border-top: 1px solid #B5D4F4;">
            <p class="text-sm" style="color: #185FA5;">
                Already have an account?
                <a href="{{ route('login') }}"
                   class="font-semibold underline ms-1"
                   style="color: #042C53;"
                   onmouseover="this.style.color='#185FA5'"
                   onmouseout="this.style.color='#042C53'">
                    Log in here
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>