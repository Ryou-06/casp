<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center py-1">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl bg-white shadow-sm border border-blue-100">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-extrabold text-xl tracking-tight" style="color: #042C53;">
                        {{ __('Submit Assignment') }}
                    </h2>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Student Workspace</p>
                </div>
            </div>
            
            <a href="{{ route('classrooms.student_show', $assignment->classroom_id) }}"
               class="group inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 bg-white border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-300">
                <svg class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Class
            </a>
        </div>
    </x-slot>

    <div class="w-full" style="background-color: #F8FAFD; min-height: 100vh; padding: 1.5rem;">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                {{-- Left Column: Assignment Details (4 Cols) --}}
                <div class="lg:col-span-5 space-y-4">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="h-1 bg-gradient-to-r from-blue-600 to-blue-400"></div>
                        <div class="p-6">
                            <div class="mb-6">
                                <h3 class="text-lg font-black leading-tight mb-2" style="color: #042C53;">{{ $assignment->title }}</h3>
                                @if($assignment->isPastDue())
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-red-50 text-red-600 border border-red-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                        Past Due
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Accepting Submissions
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100">
                                    <div class="text-blue-500 bg-white p-2 rounded-lg shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Classroom</p>
                                        <p class="text-sm font-bold text-gray-700">{{ $assignment->classroom?->name ?: 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100">
                                    <div class="text-blue-500 bg-white p-2 rounded-lg shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Deadline</p>
                                        <p class="text-sm font-bold {{ $assignment->isPastDue() ? 'text-red-600' : 'text-gray-700' }}">
                                            {{ $assignment->due_date->format('M d, Y • h:i A') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if($assignment->description)
                                <div class="mt-6">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Instructions</p>
                                    <div class="p-4 rounded-xl bg-blue-50/50 border border-blue-100 text-sm text-gray-600 leading-relaxed italic">
                                        {{ $assignment->description }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Right Column: Upload Form (7 Cols) --}}
                <div class="lg:col-span-7">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <div class="flex items-center gap-2 mb-6">
                            <h3 class="text-sm font-black uppercase tracking-widest text-gray-800">
                                {{ $existing ? 'Update Submission' : 'Submit Your Work' }}
                            </h3>
                            <div class="h-px flex-1 bg-gray-100"></div>
                        </div>

                        @if($existing)
                            <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 flex gap-3">
                                <svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <div>
                                    <p class="text-xs font-bold text-amber-800 uppercase">Active Submission</p>
                                    <p class="text-sm text-amber-700 font-medium mt-1">"{{ $existing->file_name }}"</p>
                                    <p class="text-[10px] text-amber-600 mt-1 uppercase tracking-tighter font-bold">
                                        Sent: {{ $existing->submitted_at->format('M d, Y • h:i A') }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-sm text-red-600 font-bold">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('submissions.store', $assignment) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <div>
                                <input type="file" name="file" id="file-upload" class="hidden" onchange="updateFileName(this)">
                                <label for="file-upload"
                                       class="group flex flex-col items-center justify-center w-full p-10 border-2 border-dashed rounded-2xl cursor-pointer transition-all duration-300 hover:border-blue-400 hover:bg-blue-50/30"
                                       style="border-color: #E5E7EB;">
                                    
                                    <div class="p-4 rounded-full bg-blue-50 text-blue-500 group-hover:scale-110 transition-transform duration-300 shadow-inner">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                    </div>
                                    
                                    <div class="mt-4 text-center">
                                        <p class="text-sm font-black text-gray-700 uppercase tracking-tight">Click to browse files</p>
                                        <p class="text-[11px] text-gray-400 mt-1">PDF, Word, Images, or ZIP (Max 500MB)</p>
                                    </div>
                                </label>
                                
                                <div id="file-name-display" class="hidden mt-4 p-3 rounded-xl border border-blue-100 bg-blue-50/50 flex items-center gap-3 animate-in fade-in slide-in-from-top-2">
                                    {{-- JS Inject Content --}}
                                </div>

                                @error('file')
                                    <p class="text-[11px] mt-2 font-bold text-red-500 uppercase tracking-wide px-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex gap-3 pt-2">
                                <button type="submit"
                                        class="flex-[2] px-6 py-3 rounded-xl text-white text-xs font-black uppercase tracking-widest transition-all duration-300 bg-blue-600 hover:bg-blue-700 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 shadow-md">
                                    {{ $existing ? 'Update My Work' : 'Hand In Assignment' }}
                                </button>
                                <a href="{{ route('classrooms.student_show', $assignment->classroom_id) }}"
                                   class="flex-1 px-6 py-3 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all text-center bg-gray-50 text-gray-500 hover:bg-gray-100 border border-gray-100">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<script>
function updateFileName(input) {
    const displayDiv = document.getElementById('file-name-display');
    if (input.files && input.files[0]) {
        const fileName = input.files[0].name;
        const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);
        displayDiv.innerHTML = `
            <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm text-blue-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
            </div>
            <div class="overflow-hidden">
                <p class="text-xs font-black text-blue-900 truncate uppercase tracking-tighter">${fileName}</p>
                <p class="text-[10px] text-blue-600 font-bold uppercase">${fileSize} MB • Ready to hand in</p>
            </div>
        `;
        displayDiv.classList.remove('hidden');
        displayDiv.classList.add('flex');
    } else {
        displayDiv.classList.add('hidden');
        displayDiv.classList.remove('flex');
    }
}
</script>