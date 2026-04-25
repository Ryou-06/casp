<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #042C53;">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="w-full" style="background-color: #F4F7FB; min-height: 100vh; padding: 1.5rem;">
        <div class="overflow-hidden sm:rounded-lg" style="background-color: #fff; border: 0.5px solid #B5D4F4;">
            <div class="p-6">
                <!-- Welcome -->
                <div class="mb-6 p-4 rounded-lg" style="background-color: #E6F1FB; border-left: 4px solid #185FA5;">
                    <h3 class="text-lg font-semibold" style="color: #042C53;">Welcome, {{ $user->name }}!</h3>
                    <p class="mt-1 text-sm" style="color: #185FA5;">You are logged in as a <strong style="color: #0C447C;">Teacher</strong>.</p>
                </div>

                <!-- Stats Cards -->
                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Assignments -->
                    <div class="p-6 rounded-lg" style="background-color: #E6F1FB; border-left: 4px solid #378ADD;">
                        <h4 class="font-semibold text-lg" style="color: #0C447C;">My Assignments</h4>
                        <p class="text-3xl font-bold mt-2" style="color: #185FA5;">{{ $totalAssignments }}</p>
                        <p class="text-sm mt-1" style="color: #378ADD;">Total assignments created</p>
                    </div>
                    <!-- Students -->
                    <div class="p-6 rounded-lg" style="background-color: #E1F5EE; border-left: 4px solid #1D9E75;">
                        <h4 class="font-semibold text-lg" style="color: #085041;">Students</h4>
                        <p class="text-3xl font-bold mt-2" style="color: #0F6E56;">{{ $totalStudents }}</p>
                        <p class="text-sm mt-1" style="color: #1D9E75;">Total students enrolled</p>
                    </div>
                    <!-- Submissions -->
                    <div class="p-6 rounded-lg" style="background-color: #EEF2F8; border-left: 4px solid #185FA5;">
                        <h4 class="font-semibold text-lg" style="color: #042C53;">Submissions</h4>
                        <p class="text-3xl font-bold mt-2" style="color: #0C447C;">{{ $totalSubmissions }}</p>
                        <p class="text-sm mt-1" style="color: #185FA5;">Total submissions received</p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8">
                    <h4 class="font-semibold text-lg mb-4" style="color: #042C53;">Quick Actions</h4>
                    <div class="flex gap-4">
                        <a href="{{ route('assignments.create') }}"
                           class="px-6 py-2 rounded-lg text-white font-medium transition-colors duration-150"
                           style="background-color: #185FA5;"
                           onmouseover="this.style.backgroundColor='#0C447C'"
                           onmouseout="this.style.backgroundColor='#185FA5'">
                            + Create Assignment
                        </a>
                        <a href="{{ route('assignments.index') }}"
                           class="px-6 py-2 rounded-lg text-white font-medium transition-colors duration-150"
                           style="background-color: #042C53;"
                           onmouseover="this.style.backgroundColor='#0C447C'"
                           onmouseout="this.style.backgroundColor='#042C53'">
                            View All Assignments
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>