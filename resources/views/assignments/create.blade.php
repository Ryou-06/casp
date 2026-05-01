<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Assignment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('assignments.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-1">Classroom</label>
                            <select name="classroom_id" id="classroom_id"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select classroom</option>
                                @foreach($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}"
                                            data-subject="{{ $classroom->subject }}"
                                            @selected(old('classroom_id', request('classroom_id')) == $classroom->id)>
                                        {{ $classroom->name }}{{ $classroom->section ? ' - '.$classroom->section : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('classroom_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            @if($classrooms->isEmpty())
                                <p class="text-sm mt-1" style="color: #A32D2D;">Create a classroom first before posting an activity.</p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-1">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Assignment title">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-1">Subject</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Auto-filled from selected classroom">
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-1">Description / Instructions</label>
                            <textarea name="description" rows="5"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Describe the assignment instructions...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-1">Due Date</label>
                            <input type="datetime-local" name="due_date" value="{{ old('due_date') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('due_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-3">
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition"
                                    @disabled($classrooms->isEmpty())>
                                Create Assignment
                            </button>
<a href="{{ route('classrooms.show', $classroom_id ?? request('classroom_id')) }}"
   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition">
    Cancel
</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const classroomSelect = document.getElementById('classroom_id');
        const subjectInput = document.getElementById('subject');

        function syncSubjectFromClassroom() {
            const subject = classroomSelect.options[classroomSelect.selectedIndex]?.dataset.subject || '';
            subjectInput.value = subject || subjectInput.value;
            subjectInput.readOnly = Boolean(subject);
            subjectInput.classList.toggle('bg-gray-100', Boolean(subject));
        }

        classroomSelect?.addEventListener('change', function () {
            subjectInput.value = '';
            syncSubjectFromClassroom();
        });
        syncSubjectFromClassroom();
    </script>
</x-app-layout>
