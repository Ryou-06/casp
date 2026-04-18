<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Assignments') }}
            </h2>
            <a href="{{ route('assignments.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                + New Assignment
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($assignments->isEmpty())
                        <p class="text-gray-500 text-center py-8">No assignments yet. Create your first one!</p>
                    @else
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b">
                                    <th class="pb-3 text-gray-600">Title</th>
                                    <th class="pb-3 text-gray-600">Subject</th>
                                    <th class="pb-3 text-gray-600">Due Date</th>
                                    <th class="pb-3 text-gray-600">Submissions</th>
                                    <th class="pb-3 text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignments as $assignment)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 font-medium">{{ $assignment->title }}</td>
                                        <td class="py-3 text-gray-600">{{ $assignment->subject }}</td>
                                        <td class="py-3">
                                            <span class="{{ $assignment->isPastDue() ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                                                {{ $assignment->due_date->format('M d, Y h:i A') }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            {{-- Will be linked in Step 5 --}}
                                            <span class="text-gray-600">
                                                {{ $assignment->submissions_count }} submissions
                                            </span>
                                        </td>
                                        <td class="py-3 flex gap-2">
                                            <a href="{{ route('assignments.edit', $assignment) }}"
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('assignments.destroy', $assignment) }}" method="POST"
                                                  onsubmit="return confirm('Delete this assignment?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $assignments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>