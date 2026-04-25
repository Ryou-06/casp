<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #042C53;">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="w-full" style="background-color: #F4F7FB; min-height: 100vh; padding: 1.5rem;">
        <div class="overflow-hidden sm:rounded-lg" style="background-color: #fff; border: 0.5px solid #B5D4F4;">
            <div class="p-6">
                <!-- Welcome Banner -->
                <div class="mb-6 p-4 rounded-lg" style="background-color: #E6F1FB; border-left: 4px solid #185FA5;">
                    <h3 class="text-lg font-semibold" style="color: #042C53;">Welcome, {{ $user->name }}!</h3>
                    <p class="mt-1 text-sm" style="color: #185FA5;">You are logged in as a <strong style="color: #0C447C;">Student</strong>.</p>
                </div>

                <!-- Stats Cards -->
                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Assignments -->
                    <div class="p-6 rounded-lg" style="background-color: #E6F1FB; border-left: 4px solid #378ADD;">
                        <h4 class="font-semibold text-lg" style="color: #0C447C;">Assignments</h4>
                        <p class="text-3xl font-bold mt-2" style="color: #185FA5;">{{ $totalAssignments }}</p>
                        <p class="text-sm mt-1" style="color: #378ADD;">Total assignments</p>
                    </div>
                    <!-- Completed -->
                    <div class="p-6 rounded-lg" style="background-color: #E1F5EE; border-left: 4px solid #1D9E75;">
                        <h4 class="font-semibold text-lg" style="color: #085041;">Completed</h4>
                        <p class="text-3xl font-bold mt-2" style="color: #0F6E56;">{{ $completedSubmissions }}</p>
                        <p class="text-sm mt-1" style="color: #1D9E75;">Assignments submitted</p>
                    </div>
                    <!-- Pending -->
                    <div class="p-6 rounded-lg" style="background-color: #EEF2F8; border-left: 4px solid #185FA5;">
                        <h4 class="font-semibold text-lg" style="color: #042C53;">Pending</h4>
                        <p class="text-3xl font-bold mt-2" style="color: #0C447C;">{{ $pendingAssignments }}</p>
                        <p class="text-sm mt-1" style="color: #185FA5;">Due soon</p>
                    </div>
                </div>

                <!-- Recent Assignments -->
                <div class="mt-8">
                    <h4 class="font-semibold text-lg mb-4" style="color: #042C53;">Recent Assignments</h4>
                    <div class="p-4 rounded-lg text-center text-sm" style="background-color: #E6F1FB; color: #185FA5; border: 0.5px solid #B5D4F4;">
                        No assignments yet. Check back later!
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>