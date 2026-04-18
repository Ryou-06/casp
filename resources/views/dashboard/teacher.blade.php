<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welcome, {{ $user->name }}!</h3>
                    <p class="text-gray-600 mb-4">You are logged in as a <strong>Teacher</strong>.</p>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h4 class="font-semibold text-blue-900">My Assignments</h4>
                            <p class="text-2xl font-bold text-blue-700 mt-2">{{ $totalAssignments }}</p>
                            <p class="text-sm text-blue-600">Total assignments created</p>
                        </div>

                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <h4 class="font-semibold text-green-900">Students</h4>
                            <p class="text-2xl font-bold text-green-700 mt-2">{{ $totalStudents }}</p>
                            <p class="text-sm text-green-600">Total students</p>
                        </div>

                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                            <h4 class="font-semibold text-yellow-900">Submissions</h4>
                            <p class="text-2xl font-bold text-yellow-700 mt-2">{{ $totalSubmissions }}</p>
                            <p class="text-sm text-yellow-600">Total submissions received</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="font-semibold text-gray-800 mb-3">Quick Actions</h4>
                        <div class="flex gap-3">
                            <a href="{{ route('assignments.create') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                                Create Assignment
                            </a>
                            <a href="{{ route('assignments.index') }}"
                               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
                                View All Assignments
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>