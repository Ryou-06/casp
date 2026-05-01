<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Assignments') }}
        </h2>
    </x-slot>

    <!-- Full width - remove max-w-7xl and mx-auto -->
    <div class="w-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">Assignment List</h3>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if($assignments->isEmpty())
                    <div class="text-center py-12 bg-gray-50 rounded-lg">
                        <p class="text-gray-500">No assignments created yet.</p>
                        <a href="{{ route('assignments.create') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-900">
                            Create your first assignment →
                        </a>
                    </div>
                @else
                    <!-- Full width table - remove overflow-x-auto if not needed -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Classroom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submissions</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($assignments as $assignment)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $assignment->title }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($assignment->description, 50) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $assignment->classroom?->name ?: 'No classroom' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $assignment->subject }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm {{ $assignment->isPastDue() ? 'text-red-600 font-semibold' : 'text-gray-900' }}">
                                                {{ $assignment->due_date->format('M d, Y h:i A') }}
                                            </span>
                                            @if($assignment->isPastDue())
                                                <span class="ml-2 text-xs bg-red-100 text-red-600 px-2 py-1 rounded">Past Due</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                                {{ $assignment->submissions_count }} submission(s)
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($assignment->isPastDue())
                                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Closed</span>
                                            @else
                                                <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded">Active</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex gap-3">
                                                <a href="{{ route('assignments.edit', $assignment) }}" 
                                                   class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                                <form action="{{ route('assignments.destroy', $assignment) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Delete this assignment? All submissions will also be deleted.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                         </>
                    </div>
                    
                    <div class="mt-4">
                        {{ $assignments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
