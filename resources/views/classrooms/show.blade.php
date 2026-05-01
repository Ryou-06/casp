<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #042C53;">
            {{ $classroom->name }}
        </h2>
    </x-slot>

    <div class="w-full" style="background-color: #F4F7FB; min-height: 100vh; padding: 1.5rem;">
        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded-lg text-sm" style="background-color: #E1F5EE; border: 1px solid #1D9E75; color: #085041;">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="overflow-hidden sm:rounded-lg" style="background-color: #fff; border: 0.5px solid #B5D4F4;">
                    <div class="p-6">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <h3 class="text-lg font-semibold" style="color: #042C53;">Classroom Details</h3>
                                <p class="text-sm mt-1" style="color: #185FA5;">Section: {{ $classroom->section ?: 'N/A' }}</p>
                                <p class="text-sm mt-1" style="color: #185FA5;">Subject: {{ $classroom->subject ?: 'N/A' }}</p>
                                @if($classroom->description)
                                    <p class="text-sm mt-3" style="color: #4B5563;">{{ $classroom->description }}</p>
                                @endif
                            </div>
                            <a href="{{ route('assignments.create', ['classroom_id' => $classroom->id]) }}"
                               class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-white text-sm font-medium"
                               style="background-color: #185FA5;">
                                + Post Activity
                            </a>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden sm:rounded-lg" style="background-color: #fff; border: 0.5px solid #B5D4F4;">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4" style="color: #042C53;">Enrolled Students</h3>

                        @if($classroom->students->isEmpty())
                            <div class="text-center py-8 rounded-lg" style="background-color: #E6F1FB; color: #185FA5;">
                                No students enrolled yet.
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr style="background-color: #042C53;">
                                            <th class="px-4 py-3 text-left text-xs font-medium uppercase" style="color: #B5D4F4;">Name</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium uppercase" style="color: #B5D4F4;">Email</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium uppercase" style="color: #B5D4F4;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($classroom->students as $student)
                                            <tr style="border-bottom: 0.5px solid #B5D4F4;">
                                                <td class="px-4 py-3 text-sm" style="color: #042C53;">{{ $student->name }}</td>
                                                <td class="px-4 py-3 text-sm" style="color: #185FA5;">{{ $student->email }}</td>
                                                <td class="px-4 py-3 text-sm">
                                                    <form action="{{ route('classrooms.students.destroy', [$classroom, $student]) }}" method="POST" onsubmit="return confirm('Remove this student from the classroom?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="font-medium" style="color: #A32D2D;">Remove</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="overflow-hidden sm:rounded-lg" style="background-color: #fff; border: 0.5px solid #B5D4F4;">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4" style="color: #042C53;">Posted Activities</h3>

                        @if($classroom->assignments->isEmpty())
                            <div class="text-center py-8 rounded-lg" style="background-color: #E6F1FB; color: #185FA5;">
                                No activities posted in this classroom yet.
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($classroom->assignments as $assignment)
                                    <div class="p-4 rounded-lg" style="background-color: #F4F7FB; border: 0.5px solid #B5D4F4;">
                                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                            <div>
                                                <p class="font-semibold" style="color: #042C53;">{{ $assignment->title }}</p>
                                                <p class="text-sm" style="color: #185FA5;">Due: {{ $assignment->due_date->format('M d, Y h:i A') }}</p>
                                            </div>
                                            <a href="{{ route('teacher.submissions', $assignment) }}" class="text-sm font-medium" style="color: #0C447C;">
                                                View Submissions
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="overflow-hidden sm:rounded-lg" style="background-color: #fff; border: 0.5px solid #B5D4F4;">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4" style="color: #042C53;">Add Student</h3>

                        @if($availableStudents->isEmpty())
                            <p class="text-sm" style="color: #185FA5;">No registered students available to add.</p>
                        @else
                            <form action="{{ route('classrooms.students.store', $classroom) }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1" style="color: #042C53;">Registered Students</label>
                                    <select name="student_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                        <option value="">Select student</option>
                                        @foreach($availableStudents as $student)
                                            <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->email }}</option>
                                        @endforeach
                                    </select>
                                    @error('student_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" class="w-full px-4 py-2 rounded-lg text-white font-medium" style="background-color: #185FA5;">
                                    Add Student
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
