<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assignments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($assignments->isEmpty())
                        <p class="text-gray-500 text-center py-8">No assignments available yet.</p>
                    @else
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b">
                                    <th class="pb-3 text-gray-600">Title</th>
                                    <th class="pb-3 text-gray-600">Subject</th>
                                    <th class="pb-3 text-gray-600">Due Date</th>
                                    <th class="pb-3 text-gray-600">Status</th>
                                    <th class="pb-3 text-gray-600">Action</th>
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
                                                @if($assignment->isPastDue())
                                                    <span class="text-xs bg-red-100 text-red-600 px-1 py-0.5 rounded ml-1">Past Due</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            @if($assignment->submissions_exists)
                                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-semibold">
                                                    Submitted
                                                </span>
                                            @else
                                                <span class="bg-orange-100 text-orange-700 text-xs px-2 py-1 rounded-full font-semibold">
                                                    Not Submitted
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3">
                                            @if(!$assignment->isPastDue())
                                                <a href="{{ route('submissions.create', $assignment) }}"
                                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition">
                                                    {{ $assignment->submissions_exists ? 'Re-upload' : 'Submit' }}
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-sm">Closed</span>
                                            @endif
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