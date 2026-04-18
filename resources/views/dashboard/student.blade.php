<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welcome, {{ $user->name }}!</h3>
                    <p class="text-gray-600 mb-4">You are logged in as a <strong>Student</strong>.</p>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                            <h4 class="font-semibold text-purple-900">Assignments</h4>
                            <p class="text-2xl font-bold text-purple-700 mt-2">{{ $totalAssignments }}</p>
                            <p class="text-sm text-purple-600">Total assignments</p>
                        </div>

                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <h4 class="font-semibold text-green-900">Completed</h4>
                            <p class="text-2xl font-bold text-green-700 mt-2">{{ $completedSubmissions }}</p>
                            <p class="text-sm text-green-600">Assignments submitted</p>
                        </div>

                        <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                            <h4 class="font-semibold text-orange-900">Pending</h4>
                            <p class="text-2xl font-bold text-orange-700 mt-2">{{ $pendingAssignments }}</p>
                            <p class="text-sm text-orange-600">Due soon</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="font-semibold text-gray-800 mb-3">Recent Assignments</h4>
                        <div class="bg-gray-50 p-4 rounded-lg text-center text-gray-500">
                            No assignments yet. Check back later!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>