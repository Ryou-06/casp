<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 py-4">
            <div class="flex items-center gap-5">
                <div class="relative">
                    <div class="absolute -inset-1 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-2xl blur opacity-25"></div>
                    <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-sm border border-slate-100">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h2 class="font-black text-2xl text-slate-900 tracking-tight">
                        {{ __('Assignment Dashboard') }}
                    </h2>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Live Workspace</p>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('assignments.create') }}" 
               class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl bg-slate-900 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-blue-900/20 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <svg class="relative w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="relative text-xs font-black text-white uppercase tracking-widest">New Assignment</span>
            </a>
        </div>
    </x-slot>

    <div class="w-full bg-[#FBFDFF] min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            {{-- Quick Stats Bar --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5">
                    <div class="h-12 w-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Managed</p>
                        <p class="text-xl font-black text-slate-900">{{ $assignments->count() }} Tasks</p>
                    </div>
                </div>
                {{-- Add more stat blocks here if needed --}}
            </div>

            @if(session('success'))
                <div class="mb-8 flex items-center justify-between bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-lg shadow-emerald-500/20 animate-in zoom-in-95 duration-300">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <p class="text-sm font-black uppercase tracking-wide">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-white/50 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"></path></svg>
                    </button>
                </div>
            @endif

            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden">
                @if($assignments->isEmpty())
                    <div class="text-center py-24 px-6">
                        <div class="relative inline-block mb-6">
                            <div class="absolute inset-0 bg-blue-100 rounded-full blur-2xl opacity-40 animate-pulse"></div>
                            <div class="relative h-24 w-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto text-slate-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Your desk is clear</h3>
                        <p class="text-slate-400 font-medium mt-2 max-w-xs mx-auto text-sm leading-relaxed">You haven't created any assignments yet. Ready to start your first one?</p>
                        <a href="{{ route('assignments.create') }}" class="mt-8 inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-blue-50 text-blue-600 text-xs font-black uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all duration-300">
                            Get Started
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/80 border-b border-slate-100">
                                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em]">Assignment Info</th>
                                    <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em]">Class Context</th>
                                    <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em]">Timeline</th>
                                    <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em]">Engagement</th>
                                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] text-right">Options</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($assignments as $assignment)
                                    <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                                        <td class="px-10 py-8">
                                            <div class="flex flex-col max-w-[280px]">
                                                <span class="text-base font-black text-slate-900 group-hover:text-blue-600 transition-colors">{{ $assignment->title }}</span>
                                                <span class="text-xs font-medium text-slate-400 mt-1 line-clamp-1 italic">{{ $assignment->description ?: 'No description provided.' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-8 text-center sm:text-left">
                                            <div class="flex flex-col gap-2">
                                                <span class="inline-flex items-center w-fit px-3 py-1 rounded-full bg-indigo-50 text-[10px] font-black text-indigo-600 uppercase tracking-wider">
                                                    {{ $assignment->subject }}
                                                </span>
                                                <span class="text-xs font-bold text-slate-500 ml-1">
                                                    {{ $assignment->classroom?->name ?: 'Private Session' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-8">
                                            <div class="flex flex-col">
                                                @if($assignment->isPastDue())
                                                    <span class="text-xs font-black text-red-500 uppercase tracking-tight">Expired</span>
                                                    <span class="text-[10px] font-bold text-slate-400 mt-0.5">{{ $assignment->due_date->format('M d, Y') }}</span>
                                                @else
                                                    <span class="text-xs font-black text-slate-800 uppercase tracking-tight">Due {{ $assignment->due_date->format('M d') }}</span>
                                                    <span class="text-[10px] font-bold text-slate-400 mt-0.5">{{ $assignment->due_date->format('h:i A') }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-8">
                                            <div class="flex items-center gap-3">
                                                <div class="relative h-10 w-10 flex items-center justify-center rounded-xl bg-slate-100 group-hover:bg-blue-100 transition-colors duration-300">
                                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-black text-slate-900 leading-none">{{ $assignment->submissions_count }}</p>
                                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter mt-1">Files Sent</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-10 py-8 text-right">
                                            <div class="flex justify-end items-center gap-3">
                                                <a href="{{ route('assignments.edit', $assignment) }}" 
                                                   class="h-10 w-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                                
                                                <form action="{{ route('assignments.destroy', $assignment) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Archive this assignment?')"
                                                      class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="h-10 w-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-red-600 hover:border-red-200 hover:shadow-lg hover:shadow-red-500/10 transition-all duration-300">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            @if($assignments->hasPages())
                <div class="mt-8 px-4">
                    {{ $assignments->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>