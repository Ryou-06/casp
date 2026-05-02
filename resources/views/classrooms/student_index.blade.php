<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 py-2">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white shadow-sm border border-blue-100">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div>
                <h2 class="font-black text-2xl tracking-tight leading-tight" style="color: #042C53;">
                    {{ __('My Classrooms') }}
                </h2>
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-blue-400">Student Learning Portal</p>
            </div>
        </div>
    </x-slot>

    <div class="w-full" style="background-color: #F4F7FB; min-height: 100vh; padding: 2rem 1.5rem;">
        <div class="max-w-7xl mx-auto">
            
            @if($classrooms->isEmpty())
                <div class="text-center py-20 rounded-[2.5rem] border-2 border-dashed border-blue-200 bg-white shadow-inner">
                    <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-blue-50 text-blue-300 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <p class="text-lg font-black" style="color: #042C53;">No classrooms found</p>
                    <p class="text-sm font-medium mt-1" style="color: #185FA5;">You are not enrolled in any classroom yet.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($classrooms as $classroom)
                        <a href="{{ route('student.classrooms.show', $classroom) }}"
                           class="group relative block bg-white rounded-[2rem] p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-900/10 border border-transparent hover:border-blue-100 shadow-sm overflow-hidden">
                            
                            {{-- Decorative Background element --}}
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700"></div>

                            <div class="relative">
                                {{-- Subject Badge --}}
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest mb-4 transition-colors" 
                                     style="background-color: #E6F1FB; color: #185FA5;">
                                    {{ $classroom->subject ?: 'General' }}
                                </div>

                                {{-- Classroom Name --}}
                                <h3 class="text-xl font-black leading-tight group-hover:text-blue-600 transition-colors" style="color: #042C53;">
                                    {{ $classroom->name }}
                                </h3>

                                {{-- Stats & Footer --}}
                                <div class="mt-8 flex items-center justify-between border-t border-gray-50 pt-4">
                                    <div class="flex items-center gap-2">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                        </div>
                                        <span class="text-xs font-black" style="color: #378ADD;">
                                            {{ $classroom->assignments_count }} 
                                            <span class="font-bold text-gray-400">Activities</span>
                                        </span>
                                    </div>

                                    <div class="h-8 w-8 flex items-center justify-center rounded-full bg-gray-50 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $classrooms->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>