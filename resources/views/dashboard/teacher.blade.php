<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl tracking-tight" style="color: #042C53;">
                {{ __('Teacher Dashboard') }}
            </h2>
            <!-- Added a date display for a professional touch -->
            <span class="text-sm font-medium px-4 py-1.5 bg-white rounded-full border border-blue-100 shadow-sm" style="color: #185FA5;">
                {{ now()->format('F d, Y') }}
            </span>
        </div>
    </x-slot>

    <div class="w-full" style="background-color: #F4F7FB; min-height: 100vh; padding: 2rem 1.5rem;">
        <div class="max-w-7xl mx-auto">
            <div class="overflow-hidden sm:rounded-2xl shadow-sm" style="background-color: #fff; border: 1px solid #B5D4F4;">
                <div class="p-8">
                    
                    <!-- Welcome Section: Refined with a gradient feel -->
                    <div class="mb-8 p-6 rounded-xl shadow-inner transition-all hover:shadow-md" 
                         style="background: linear-gradient(135deg, #E6F1FB 0%, #f0f7ff 100%); border-left: 5px solid #185FA5;">
                        <h3 class="text-xl font-bold" style="color: #042C53;">Welcome back, {{ $user->name }}! 👋</h3>
                        <p class="mt-1 text-sm font-medium" style="color: #185FA5;">
                            You are currently managing your portal as a <span class="px-2 py-0.5 rounded bg-white border border-blue-200" style="color: #0C447C;">Teacher</span>
                        </p>
                    </div>

                    <!-- Stats Cards: Added Hover Effects and Spacing -->
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        
                        <!-- Classrooms -->
                        <div class="p-6 rounded-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-lg bg-white border border-blue-50" 
                             style="border-left: 4px solid #185FA5; background-color: #E6F1FB;">
                            <h4 class="font-semibold text-sm uppercase tracking-wider opacity-80" style="color: #042C53;">My Classrooms</h4>
                            <p class="text-4xl font-extrabold mt-3" style="color: #0C447C;">{{ $totalClassrooms }}</p>
                            <p class="text-xs mt-2 font-medium" style="color: #185FA5;">Total classrooms created</p>
                        </div>

                        <!-- Assignments -->
                        <div class="p-6 rounded-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-lg bg-white border border-blue-50" 
                             style="border-left: 4px solid #378ADD; background-color: #E6F1FB;">
                            <h4 class="font-semibold text-sm uppercase tracking-wider opacity-80" style="color: #0C447C;">My Assignments</h4>
                            <p class="text-4xl font-extrabold mt-3" style="color: #185FA5;">{{ $totalAssignments }}</p>
                            <p class="text-xs mt-2 font-medium" style="color: #378ADD;">Total assignments created</p>
                        </div>

                        <!-- Students -->
                        <div class="p-6 rounded-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-lg bg-white border border-green-50" 
                             style="border-left: 4px solid #1D9E75; background-color: #E1F5EE;">
                            <h4 class="font-semibold text-sm uppercase tracking-wider opacity-80" style="color: #085041;">Total Students</h4>
                            <p class="text-4xl font-extrabold mt-3" style="color: #0F6E56;">{{ $totalStudents }}</p>
                            <p class="text-xs mt-2 font-medium" style="color: #1D9E75;">Total students enrolled</p>
                        </div>

                        <!-- Submissions -->
                        <div class="p-6 rounded-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-lg bg-white border border-blue-50" 
                             style="border-left: 4px solid #185FA5; background-color: #EEF2F8;">
                            <h4 class="font-semibold text-sm uppercase tracking-wider opacity-80" style="color: #042C53;">Submissions</h4>
                            <p class="text-4xl font-extrabold mt-3" style="color: #0C447C;">{{ $totalSubmissions }}</p>
                            <p class="text-xs mt-2 font-medium" style="color: #185FA5;">Total submissions received</p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>