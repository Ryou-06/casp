<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl tracking-tight" style="color: #042C53;">
                    {{ $classroom->name }}
                </h2>
                <div class="flex items-center gap-4 mt-1">
                    <span class="text-sm font-medium px-2 py-0.5 rounded" style="background-color: #E6F1FB; color: #185FA5;">
                        Section: {{ $classroom->section ?: 'N/A' }}
                    </span>
                    <span class="text-sm font-medium px-2 py-0.5 rounded" style="background-color: #E6F1FB; color: #185FA5;">
                        Subject: {{ $classroom->subject ?: 'N/A' }}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('classrooms.index') }}" class="px-4 py-2 text-sm font-bold text-gray-500 hover:text-gray-700 transition">
                    Back to Dashboard
                </a>
                <a href="{{ route('assignments.create', ['classroom_id' => $classroom->id]) }}"
                   class="inline-flex items-center px-5 py-2.5 rounded-xl text-white text-sm font-bold shadow-sm transition-all hover:brightness-110 active:scale-95"
                   style="background-color: #185FA5;">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Post Activity
                </a>
            </div>
        </div>
    </x-slot>

    <div class="w-full min-h-screen" style="background-color: #F4F7FB; padding: 2rem 1.5rem;">
        
        @if(session('success'))
            <div class="max-w-7xl mx-auto mb-6 flex items-center p-4 rounded-xl border animate-fade-in" style="background-color: #E1F5EE; border-color: #1D9E75; color: #085041;">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Main Content -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- About Classroom -->
                @if($classroom->description)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-transparent" style="border-left: 4px solid #185FA5;">
                    <h3 class="text-xs font-bold uppercase tracking-wider mb-2" style="color: #185FA5;">Classroom Description</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $classroom->description }}</p>
                </div>
                @endif

                <!-- Enrolled Students Card -->
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden" style="border-color: #B5D4F4;">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg" style="background-color: #E6F1FB; color: #185FA5;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold" style="color: #042C53;">Enrolled Students</h3>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full" style="background-color: #F4F7FB; color: #185FA5;">
                            {{ $classroom->students->count() }} Total
                        </span>
                    </div>

                    <div class="p-0">
                        @if($classroom->students->isEmpty())
                            <div class="text-center py-12">
                                <p class="text-gray-400 font-medium">No students enrolled yet.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr style="background-color: #F9FAFB;">
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Name</th>
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Email Address</th>
                                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-500">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($classroom->students as $student)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white" style="background-color: #185FA5;">
                                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                                        </div>
                                                        <span class="font-bold text-sm" style="color: #042C53;">{{ $student->name }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $student->email }}</td>
                                                <td class="px-6 py-4 text-center">
                                                    <form action="{{ route('classrooms.students.destroy', [$classroom, $student]) }}" method="POST" onsubmit="return confirm('Remove this student from the classroom?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-xs font-bold uppercase tracking-tighter hover:underline" style="color: #A32D2D;">
                                                            Remove
                                                        </button>
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

                <!-- Posted Activities Card -->
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden" style="border-color: #B5D4F4;">
                    <div class="p-6 border-b border-gray-100 flex items-center gap-3">
                        <div class="p-2 rounded-lg" style="background-color: #FEF3C7; color: #D97706;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold" style="color: #042C53;">Posted Activities</h3>
                    </div>

                    <div class="p-6">
                        @if($classroom->assignments->isEmpty())
                            <div class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                <p class="text-gray-400 font-medium italic">No activities posted yet.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($classroom->assignments as $assignment)
                                    <div class="group p-4 rounded-xl border transition-all hover:shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-4" style="border-color: #E6F1FB;">
                                        <div class="flex items-center gap-4">
                                            <div class="w-2 h-10 rounded-full" style="background-color: #185FA5;"></div>
                                            <div>
                                                <p class="font-bold text-lg" style="color: #042C53;">{{ $assignment->title }}</p>
                                                <div class="flex items-center text-xs font-semibold" style="color: #185FA5;">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path></svg>
                                                    Due: {{ $assignment->due_date->format('M d, Y • h:i A') }}
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('teacher.submissions', $assignment) }}" 
                                           class="px-4 py-2 rounded-lg text-sm font-bold transition-all border-2 border-transparent hover:bg-gray-100 text-center" 
                                           style="color: #185FA5; background-color: #F0F7FF;">
                                            View Submissions
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="space-y-6">
                <!-- Add Student Form -->
                <div class="bg-white rounded-2xl shadow-lg border p-6 sticky top-8" style="border-color: #185FA5;">
                    <h3 class="text-lg font-bold mb-1" style="color: #042C53;">Quick Enroll</h3>
                    <p class="text-xs font-medium mb-6" style="color: #185FA5;">Add a student to this class</p>

                    @if($availableStudents->isEmpty())
                        <div class="p-4 rounded-lg text-center bg-gray-50 border border-dashed border-gray-300">
                            <p class="text-sm text-gray-500 font-medium">No available students found.</p>
                        </div>
                    @else
                        <form action="{{ route('classrooms.students.store', $classroom) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: #042C53;">Select Student</label>
                                <select name="student_id" class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-[#185FA5] focus:border-[#185FA5] transition-all text-sm">
                                    <option value="">-- Choose from List --</option>
                                    @foreach($availableStudents as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full py-3 rounded-xl text-white font-bold shadow-lg transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2" style="background-color: #185FA5;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                Add to Classroom
                            </button>
                        </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>