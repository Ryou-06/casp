<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl tracking-tight" style="color: #042C53;">
                {{ __('Account Settings') }}
            </h2>
            <span class="text-sm font-medium px-4 py-1.5 bg-white rounded-full border border-blue-100 shadow-sm capitalize" style="color: #185FA5;">
                {{ $user->role === 'teacher' ? 'Teacher/Admin' : $user->role }}
            </span>
        </div>
    </x-slot>

    <div class="w-full" style="background-color: #F4F7FB; min-height: 100vh; padding: 2rem 1.5rem;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-2xl border" style="border-color: #B5D4F4;">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-2xl border" style="border-color: #B5D4F4;">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
