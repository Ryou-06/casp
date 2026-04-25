<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Submissions: {{ $assignment->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <!-- Back Button -->
                    <div class="mb-4">
                        <a href="{{ route('assignments.index') }}" class="text-blue-600 hover:text-blue-900">
                            ← Back to Assignments
                        </a>
                    </div>
                    
                    <!-- Assignment Info -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Subject</p>
                                <p class="font-semibold">{{ $assignment->subject }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Due Date</p>
                                <p class="font-semibold {{ $assignment->isPastDue() ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $assignment->due_date->format('F d, Y h:i A') }}
                                    @if($assignment->isPastDue())
                                        <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded ml-2">Past Due</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Submissions</p>
                                <p class="font-semibold text-2xl">{{ $submissions->total() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <!-- Submissions Table -->
                    @if($submissions->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <p class="text-gray-500">No submissions yet for this assignment.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Size</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted At</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($submissions as $index => $submission)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $submissions->firstItem() + $index }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $submission->student->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $submission->student->email }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 break-all">
                                                    {{ $submission->file_name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $submission->formatted_file_size }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $submission->submitted_at->format('M d, Y h:i A') }}
                                                <br>
                                                <span class="text-xs text-gray-400">{{ $submission->submitted_at->diffForHumans() }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ Storage::url($submission->file_path) }}" 
                                                   target="_blank"
                                                   class="text-blue-600 hover:text-blue-900 mr-3">
                                                    Download
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $submissions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>