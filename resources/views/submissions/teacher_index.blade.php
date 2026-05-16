<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #042C53;">
                Submissions: {{ $assignment->title }}
            </h2>
            <div class="flex gap-2">
                <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">
                    On Time: {{ $submissions->filter(function($s) use ($assignment) { return !$assignment->isSubmissionLate($s->submitted_at); })->count() }}
                </span>
                <span class="text-xs px-3 py-1 rounded-full bg-red-100 text-red-700 font-semibold">
                    Late: {{ $submissions->filter(function($s) use ($assignment) { return $assignment->isSubmissionLate($s->submitted_at); })->count() }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="w-full" style="background-color: #F4F7FB; min-height: 100vh; padding: 1.5rem;">
        <div class="overflow-hidden sm:rounded-lg" style="background-color: #fff; border: 0.5px solid #B5D4F4;">
            <div class="p-6">

                <!-- Back Button -->
                <div class="mb-5">
                    <a href="{{ $assignment->classroom ? route('classrooms.show', $assignment->classroom) : route('classrooms.index') }}"
                       class="text-sm font-medium transition-colors duration-150 inline-flex items-center gap-2"
                       style="color: #185FA5;"
                       onmouseover="this.style.color='#042C53'"
                       onmouseout="this.style.color='#185FA5'">
                        ← Back to Assignments
                    </a>
                </div>

                <!-- Assignment Info -->
                <div class="p-4 rounded-lg mb-6" style="background-color: #E6F1FB; border: 0.5px solid #B5D4F4;">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider mb-1" style="color: #378ADD;">Subject</p>
                            <p class="font-semibold text-sm" style="color: #042C53;">{{ $assignment->subject }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider mb-1" style="color: #378ADD;">Due Date</p>
                            <p class="font-semibold text-sm" style="color: {{ $assignment->isPastDue() ? '#A32D2D' : '#0F6E56' }};">
                                {{ $assignment->due_date->format('F d, Y h:i A') }}
                                @if($assignment->isPastDue())
                                    <span class="text-xs px-2 py-0.5 rounded ml-1" style="background-color: #FCEBEB; color: #A32D2D;">Past Due</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider mb-1" style="color: #378ADD;">Total Submissions</p>
                            <p class="font-semibold text-2xl" style="color: #042C53;">{{ $submissions->total() }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider mb-1" style="color: #378ADD;">Late Policy</p>
                            <p class="text-xs font-semibold" style="color: #A32D2D;">Late submissions are accepted and marked</p>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-4 px-4 py-3 rounded-lg text-sm" style="background-color: #E1F5EE; border: 1px solid #1D9E75; color: #085041;">
                        {{ session('success') }}
                    </div>
                @endif

                @if($submissions->isEmpty())
                    <div class="text-center py-12 rounded-lg" style="background-color: #E6F1FB;">
                        <p class="text-sm" style="color: #185FA5;">No submissions yet for this assignment.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full" style="border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #042C53;">
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Student Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">File Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">File Size</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Submitted At</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissions as $index => $submission)
                                    @php
                                        $isLate = $assignment->isSubmissionLate($submission->submitted_at);
                                    @endphp
                                    <tr style="border-bottom: 0.5px solid #B5D4F4; {{ $isLate ? 'background-color: #FFF5F5;' : '' }}"
                                        onmouseover="this.style.backgroundColor='#E6F1FB'"
                                        onmouseout="this.style.backgroundColor='{{ $isLate ? '#FFF5F5' : 'transparent' }}'">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: #185FA5;">
                                            {{ $submissions->firstItem() + $index }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium" style="color: #042C53;">{{ $submission->student->name }}</div>
                                            <div class="text-xs mt-0.5" style="color: #378ADD;">{{ $submission->student->email }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm break-all" style="color: #042C53;">{{ $submission->file_name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: #185FA5;">
                                            {{ $submission->formatted_file_size }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm" style="color: {{ $isLate ? '#A32D2D' : '#185FA5' }};">
                                                {{ $submission->submitted_at->format('M d, Y h:i A') }}
                                            </div>
                                            <div class="text-xs" style="color: #378ADD;">{{ $submission->submitted_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($isLate)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider" 
                                                      style="background-color: #FCEBEB; color: #A32D2D; border: 1px solid #F5C6C6;">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    LATE
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider"
                                                      style="background-color: #E1F5EE; color: #0F6E56; border: 1px solid #B8E6D6;">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    ON TIME
                                                </span>
                                            @endif
                                         </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ route('teacher.submissions.view', $submission) }}"
                                                   target="_blank"
                                                   class="px-3 py-1 rounded text-xs font-medium transition-colors duration-150 inline-flex items-center gap-1"
                                                   style="background-color: #E1F5EE; color: #0F6E56; border: 1px solid #B8E6D6;"
                                                   onmouseover="this.style.backgroundColor='#0F6E56';this.style.color='white'"
                                                   onmouseout="this.style.backgroundColor='#E1F5EE';this.style.color='#0F6E56'">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0A9 9 0 113 12a9 9 0 0118 0z"></path>
                                                    </svg>
                                                    View
                                                </a>
                                                <a href="{{ route('teacher.submissions.download', $submission) }}"
                                                   class="px-3 py-1 rounded text-xs font-medium transition-colors duration-150 inline-flex items-center gap-1"
                                                   style="background-color: #E6F1FB; color: #0C447C; border: 1px solid #B5D4F4;"
                                                   onmouseover="this.style.backgroundColor='#185FA5';this.style.color='white'"
                                                   onmouseout="this.style.backgroundColor='#E6F1FB';this.style.color='#0C447C'">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                    </svg>
                                                    Download
                                                </a>
                                            </div>
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
</x-app-layout>
