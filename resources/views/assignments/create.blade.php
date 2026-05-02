<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl tracking-tight" style="color: #042C53;">
                {{ __('Create New Activity') }}
            </h2>
            <a href="{{ route('classrooms.index') }}" class="text-sm font-semibold flex items-center hover:underline" style="color: #185FA5;">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 8.959 8.959 0 01-9 9m-9-9a9 9 0 019-9"></path></svg>
                Exit to Dashboard
            </a>
        </div>
    </x-slot>

    <!-- Main Container: Centered, No Scroll -->
    <div class="w-full flex items-center justify-center overflow-hidden" 
         style="background-color: #F4F7FB; height: calc(100vh - 65px); padding: 1.5rem;">
        
        <div class="w-full max-w-2xl">
            <!-- Form Card -->
            <div class="bg-white shadow-xl sm:rounded-2xl border flex flex-col overflow-hidden" 
                 style="border-color: #B5D4F4; max-height: 85vh;">
                
                <!-- Card Header -->
                <div class="p-5 border-b border-gray-100 flex items-center gap-3 bg-white">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center shadow-sm" style="background-color: #FEF3C7; color: #D97706;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold" style="color: #042C53;">Assignment Setup</h3>
                        <p class="text-xs font-medium" style="color: #185FA5;">Assign tasks and deadlines to your students</p>
                    </div>
                </div>

                <!-- Scrollable Form Body -->
                <div class="p-6 overflow-y-auto custom-scrollbar bg-gray-50/30">
                    <form action="{{ route('assignments.store') }}" method="POST">
                        @csrf

                        <div class="space-y-5">
                            <!-- Classroom Selection -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: #042C53;">Target Classroom</label>
                                <select name="classroom_id" id="classroom_id"
                                        class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-[#185FA5] focus:border-[#185FA5] transition-all shadow-sm text-sm">
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
                                    <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                                @if($classrooms->isEmpty())
                                    <p class="text-xs mt-2 font-bold flex items-center" style="color: #A32D2D;">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        Create a classroom first before posting.
                                    </p>
                                @endif
                            </div>

                            <!-- Title -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: #042C53;">Activity Title</label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                       class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-[#185FA5] focus:border-[#185FA5] shadow-sm text-sm"
                                       placeholder="e.g. Midterm Project">
                                @error('title')
                                    <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Subject (Auto-filled) -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: #042C53;">Subject</label>
                                <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                                       class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-[#185FA5] focus:border-[#185FA5] shadow-sm text-sm"
                                       placeholder="Auto-filled from classroom">
                                @error('subject')
                                    <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: #042C53;">Instructions</label>
                                <textarea name="description" rows="4"
                                          class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-[#185FA5] focus:border-[#185FA5] shadow-sm text-sm"
                                          placeholder="Provide clear steps for your students...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Due Date -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: #042C53;">Deadline</label>
                                <input type="datetime-local" name="due_date" value="{{ old('due_date') }}"
                                       class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-[#185FA5] focus:border-[#185FA5] shadow-sm text-sm">
                                @error('due_date')
                                    <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-8 pt-6 border-t border-gray-100 flex items-center gap-3">
                            <button type="submit"
                                    class="flex-1 px-6 py-3 rounded-xl text-white font-bold transition-all duration-200 shadow-md hover:brightness-110 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                                    style="background-color: #185FA5;"
                                    @disabled($classrooms->isEmpty())>
                                Create Assignment
                            </button>
                            
                            <a href="{{ route('classrooms.show', $classroom_id ?? request('classroom_id')) }}"
                               class="px-6 py-3 rounded-xl font-bold transition-all text-gray-500 hover:bg-gray-100 text-sm">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scrollbar Styling -->
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #B5D4F4; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #185FA5; }
    </style>

    <!-- YOUR ORIGINAL SCRIPT PRESERVED -->
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