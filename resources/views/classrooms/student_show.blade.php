<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div>

                <h2 class="font-bold text-2xl leading-tight" style="color: #042C53;">

                    {{ $classroom->name }}

                </h2>

            

            </div>

           

            {{-- Restored Button with updated text --}}

            <a href="{{ route('student.classrooms.index') }}"

               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"

               style="background-color: #E6F1FB; color: #185FA5;"

               onmouseover="this.style.backgroundColor='#B5D4F4'; this.style.transform='translateX(-2px)'"

               onmouseout="this.style.backgroundColor='#E6F1FB'; this.style.transform='translateX(0)'">

                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>

                </svg>

                Back to Classrooms

            </a>

        </div>

    </x-slot>



    <div class="w-full" style="background-color: #F4F7FB; min-height: 100vh; padding: 1.5rem;">

        <div class="max-w-5xl mx-auto space-y-6">

           

            {{-- Teacher Stats Overview --}}

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                <div class="p-5 rounded-xl bg-white border border-gray-200 shadow-sm">

                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Total Activities</p>

                    <p class="text-2xl font-black" style="color: #042C53;">{{ $classroom->assignments->count() }}</p>

                </div>

                <div class="p-5 rounded-xl bg-white border border-gray-200 shadow-sm">

                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Subject</p>

                    <p class="text-2xl font-black" style="color: #185FA5;">{{ $classroom->subject ?: 'General' }}</p>

                </div>

                <div class="p-5 rounded-xl bg-white border border-gray-200 shadow-sm">

                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Section</p>

                    <p class="text-2xl font-black" style="color: #378ADD;">{{ $classroom->section ?: 'N/A' }}</p>

                </div>

            </div>



            {{-- Classroom Info Card --}}

            <div class="overflow-hidden sm:rounded-xl transition-all duration-300 shadow-sm"

                 style="background-color: #fff; border: 1px solid #E5E7EB;">

                <div class="relative">

                    <div class="h-1.5" style="background: linear-gradient(90deg, #185FA5 0%, #378ADD 100%);"></div>

                   

                    <div class="p-6">

                        <div class="flex items-start justify-between">

                            <div class="flex-1">

                                <div class="flex items-center gap-4">

                                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-inner"

                                         style="background-color: #F0F7FF;">

                                        <svg class="w-8 h-8" style="color: #185FA5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>

                                        </svg>

                                    </div>

                                    <div>

                                        <h3 class="text-xl font-extrabold" style="color: #042C53;">Class Details</h3>

                                        <p class="text-sm" style="color: #6B7280;">{{ $classroom->description ?: 'No description provided for this classroom.' }}</p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            {{-- Activities Management Card --}}

            <div class="overflow-hidden sm:rounded-xl shadow-sm"

                 style="background-color: #fff; border: 1px solid #E5E7EB;">

                <div class="p-6">

                    <div class="flex items-center justify-between mb-6">

                        <div class="flex items-center gap-2">

                            <div class="p-2 rounded-lg" style="background-color: #E6F1FB;">

                                <svg class="w-5 h-5" style="color: #185FA5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>

                                </svg>

                            </div>

                            <h3 class="text-lg font-bold" style="color: #042C53;">Assignment List</h3>

                        </div>

                    </div>



                    @if($classroom->assignments->isEmpty())

                        <div class="text-center py-12 rounded-xl border-2 border-dashed border-gray-100" style="background-color: #FAFCFF;">

                            <p class="font-medium text-gray-400">No activities have been created yet.</p>

                        </div>

                    @else

                        <div class="space-y-4">

                            @foreach($classroom->assignments as $assignment)

                                <div class="group p-5 rounded-xl transition-all duration-200 border border-gray-100 hover:border-blue-200 hover:shadow-md bg-white">

                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                                        <div class="flex-1">

                                            <div class="flex items-center gap-3">

                                                <div class="w-2 h-10 rounded-full" style="background-color: {{ $assignment->isPastDue() ? '#EF4444' : '#10B981' }}"></div>

                                                <div>

                                                    <h4 class="font-bold text-gray-800 text-lg group-hover:text-blue-700 transition-colors">

                                                        {{ $assignment->title }}

                                                    </h4>

                                                    <div class="flex items-center gap-4 mt-1">

                                                        <span class="flex items-center gap-1 text-xs font-medium text-gray-500">

                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>

                                                            </svg>

                                                            Due: {{ $assignment->due_date->format('M d, Y h:i A') }}

                                                        </span>

                                                        <span class="text-[10px] uppercase tracking-widest px-2 py-0.5 rounded-md font-bold"

                                                              style="background-color: {{ $assignment->isPastDue() ? '#FEE2E2' : '#D1FAE5' }};

                                                                     color: {{ $assignment->isPastDue() ? '#991B1B' : '#065F46' }};">

                                                            {{ $assignment->isPastDue() ? 'Closed' : 'Active' }}

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                       

                                        <div class="flex items-center gap-2 shrink-0">

                                            <a href="{{ route('submissions.create', $assignment) }}"

                                               class="px-4 py-2 rounded-lg text-sm font-bold transition-all duration-200"

                                               style="background-color: #F3F4F6; color: #374151;"

                                               onmouseover="this.style.backgroundColor='#E5E7EB'"

                                               onmouseout="this.style.backgroundColor='#F3F4F6'">

                                                View Task

                                            </a>

                                           

                                            @if(!$assignment->isPastDue())

                                                <div class="p-2 rounded-lg bg-green-50 text-green-600">

                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>

                                                    </svg>

                                                </div>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>

