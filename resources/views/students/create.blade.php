<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl tracking-tight" style="color: #042C53;">
                Create Student Account
            </h2>
            <a href="{{ route('classrooms.index') }}"
               class="px-4 py-2 rounded-lg text-sm font-bold text-white"
               style="background-color: #185FA5;">
                Manage Classrooms
            </a>
        </div>
    </x-slot>

    <div class="w-full" style="background-color: #F4F7FB; min-height: 100vh; padding: 2rem 1.5rem;">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border p-8" style="border-color: #B5D4F4;">
                <h3 class="text-lg font-bold mb-1" style="color: #042C53;">New Student Credentials</h3>
                <p class="text-sm mb-6" style="color: #185FA5;">Create the account here, then give the email and temporary password to the student.</p>

                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl border" style="background-color: #E1F5EE; border-color: #1D9E75;">
                        <p class="font-bold text-sm" style="color: #085041;">{{ session('success') }}</p>
                        <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div class="p-3 bg-white rounded-lg border border-green-100">
                                <span class="block text-xs font-bold uppercase tracking-wider" style="color: #0F6E56;">Email</span>
                                <span class="font-semibold" style="color: #042C53;">{{ session('student_email') }}</span>
                            </div>
                            <div class="p-3 bg-white rounded-lg border border-green-100">
                                <span class="block text-xs font-bold uppercase tracking-wider" style="color: #0F6E56;">Temporary Password</span>
                                <span class="font-semibold" style="color: #042C53;">{{ session('student_password') }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('students.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: #042C53;">Student Name</label>
                        <x-text-input id="name" name="name" type="text" class="block w-full" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: #042C53;">Email</label>
                        <x-text-input id="email" name="email" type="email" class="block w-full" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: #042C53;">Temporary Password</label>
                            <x-text-input id="password" name="password" type="text" class="block w-full" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: #042C53;">Confirm Password</label>
                            <x-text-input id="password_confirmation" name="password_confirmation" type="text" class="block w-full" required autocomplete="new-password" />
                        </div>
                    </div>

                    <button type="submit"
                            class="px-6 py-3 rounded-lg text-white font-bold shadow-sm transition-all hover:brightness-110"
                            style="background-color: #185FA5;">
                        Create Student Account
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border p-6" style="border-color: #B5D4F4;">
                <h3 class="text-lg font-bold mb-1" style="color: #042C53;">Student List</h3>
                <p class="text-xs font-medium mb-4" style="color: #185FA5;">Existing student accounts available for classroom enrollment.</p>

                @if($students->isEmpty())
                    <div class="p-4 rounded-lg text-center bg-gray-50 border border-dashed border-gray-300">
                        <p class="text-sm text-gray-500 font-medium">No student accounts yet.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($students as $student)
                            <div class="p-3 rounded-lg border border-blue-100 bg-blue-50/40">
                                <p class="font-bold text-sm" style="color: #042C53;">{{ $student->name }}</p>
                                <p class="text-xs" style="color: #185FA5;">{{ $student->email }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
