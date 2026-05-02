<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 py-2">
            <div class="relative">
                {{-- Soft ambient glow behind title for 'Life' --}}
                <div class="absolute -top-6 -left-6 w-24 h-24 bg-blue-400/10 rounded-full blur-3xl"></div>
                
                <h2 class="relative font-black text-4xl tracking-tight" style="color: #042C53;">
                    {{ __('My Classrooms') }}
                </h2>
                <div class="relative flex items-center gap-2 mt-1.5">
                    <span class="flex h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                    <p class="text-xs font-extrabold uppercase tracking-widest" style="color: #378ADD;">
                        {{ $classrooms->count() }} {{ Str::plural('Active', $classrooms->count()) }}
                    </p>
                </div>
            </div>
            
            {{-- Modern floating status pill --}}
            <div class="flex items-center px-5 py-2.5 bg-white rounded-2xl border border-blue-50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-transform hover:scale-105">
                <span class="relative flex h-2.5 w-2.5 mr-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                </span>
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Student Portal Online</span>
            </div>
        </div>
    </x-slot>

    {{-- Refined, lively background with subtle organic shapes --}}
    <div class="w-full relative overflow-hidden" style="background: radial-gradient(circle at 0% 0%, #F8FAFC 0%, #EFF6FF 100%); min-height: 100vh; padding: 2.5rem 1.5rem;">
        
        {{-- Decorative background blobs --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-200/20 rounded-full filter blur-[100px] -mr-48 -mt-48 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-200/20 rounded-full filter blur-[80px] -ml-32 -mb-32 pointer-events-none"></div>

        @if($classrooms->isEmpty())
            <div class="relative max-w-lg mx-auto mt-24 text-center">
                <div class="bg-white/80 backdrop-blur-xl rounded-[3rem] p-16 border border-white shadow-2xl">
                    <div class="w-24 h-24 mx-auto mb-8 bg-blue-50 rounded-[2.5rem] flex items-center justify-center rotate-6 shadow-inner text-blue-500">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black mb-3" style="color: #042C53;">Empty Desk</h3>
                    <p class="text-gray-500 font-bold px-6 leading-relaxed">Hang tight! Your enrolled classrooms will pop up here as soon as your teacher adds you.</p>
                </div>
            </div>
        @else
            <div class="relative grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">
                @foreach($classrooms as $classroom)
                    <div class="group relative bg-white rounded-[2.8rem] border border-gray-100 transition-all duration-500 hover:shadow-[0_40px_90px_-20px_rgba(4,44,83,0.18)] hover:-translate-y-2 overflow-hidden flex flex-col">
                        
                        {{-- Top Energy Bar --}}
                        <div class="h-2.5 w-full bg-gradient-to-r from-[#042C53] via-[#185FA5] to-[#378ADD]"></div>

                        <div class="p-8 flex flex-col flex-1">
                            <div class="flex justify-between items-start mb-8">
                                <div class="flex-1 pr-4">
                                    @if($classroom->subject)
                                        <div class="inline-flex px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-[0.15em] mb-4 shadow-sm" 
                                              style="background-color: #F0F7FF; color: #185FA5; border: 1px solid #DDEBFF;">
                                            {{ $classroom->subject }}
                                        </div>
                                    @endif
                                    <h3 class="text-2xl font-black leading-[1.1] group-hover:text-[#185FA5] transition-colors line-clamp-2" 
                                        style="color: #042C53;">
                                        {{ $classroom->name }}
                                    </h3>
                                </div>

                                {{-- Tactics Icon: Floats and rotates on card hover --}}
                                <div class="w-16 h-16 rounded-[1.8rem] flex items-center justify-center shrink-0 font-black text-2xl shadow-inner transition-all duration-700 group-hover:rotate-[15deg] group-hover:scale-110"
                                     style="background: #F4F7FB; color: #042C53;">
                                    {{ strtoupper(substr($classroom->name, 0, 2)) }}
                                </div>
                            </div>

                            {{-- Middle Info 'Glass' Pod --}}
                            <div class="flex items-center gap-4 p-4 rounded-[1.8rem] bg-gray-50/80 border border-gray-100 mb-8 transition-all group-hover:bg-blue-50/50 group-hover:border-blue-100">
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-[#378ADD] shadow-sm border border-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="flex flex-col overflow-hidden">
                                    <span class="text-[9px] font-black uppercase text-gray-400 tracking-widest mb-0.5">Instructor</span>
                                    <span class="text-sm font-bold text-gray-700 truncate">{{ $classroom->teacher?->name ?? 'Head Professor' }}</span>
                                </div>
                                <div class="ml-auto flex flex-col items-end">
                                    <span class="text-[9px] font-black uppercase text-gray-400 tracking-widest mb-0.5">Section</span>
                                    <span class="text-xs font-black px-2.5 py-0.5 rounded-lg bg-white border border-gray-100" style="color: #185FA5;">{{ $classroom->section ?? 'A' }}</span>
                                </div>
                            </div>

                            {{-- Footer Interaction Area --}}
                            <div class="mt-auto flex items-center justify-between pt-2">
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-1.5 mb-1">
                                        <span class="relative flex h-1.5 w-1.5">
                                            <span class="animate-ping absolute h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                            <span class="relative rounded-full h-1.5 w-1.5 bg-blue-500"></span>
                                        </span>
                                        <span class="text-[9px] uppercase font-black text-gray-400 tracking-widest">Active Tasks</span>
                                    </div>
                                    <span class="text-3xl font-black tabular-nums tracking-tighter" style="color: #042C53;">
                                        {{ $classroom->assignments_count }}
                                    </span>
                                </div>

                                <a href="{{ route('student.classrooms.show', $classroom) }}"
                                   class="relative inline-flex items-center justify-center px-8 py-4 rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] transition-all duration-300 group/btn shadow-[0_10px_25px_-10px_rgba(24,95,165,0.4)] active:scale-95"
                                   style="background-color: #185FA5; color: white;">
                                    {{-- Slide-over hover background --}}
                                    <div class="absolute inset-0 w-0 bg-[#042C53] transition-all duration-300 group-hover/btn:w-full rounded-2xl"></div>
                                    
                                    <span class="relative z-10 flex items-center">
                                        Open
                                        <svg class="w-4 h-4 ml-2.5 transition-transform duration-300 group-hover/btn:translate-x-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>