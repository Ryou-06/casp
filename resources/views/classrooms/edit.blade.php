<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl tracking-tight" style="color: #042C53;">
                {{ __('Edit Classroom') }}
            </h2>
            <a href="{{ route('classrooms.index') }}" class="text-sm font-semibold flex items-center hover:underline" style="color: #185FA5;">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <!-- Main Container: Fixed height to match screen, removes outer scroll -->
    <div class="w-full flex items-center justify-center overflow-hidden" 
         style="background-color: #F4F7FB; height: calc(100vh - 65px); padding: 1rem;">
        
        <div class="w-full max-w-2xl">
            <!-- Form Card -->
            <div class="bg-white shadow-xl sm:rounded-2xl border flex flex-col overflow-hidden" 
                 style="border-color: #B5D4F4; max-height: 85vh;">
                
                <!-- Card Header -->
                <div class="p-5 border-b border-gray-100 flex items-center gap-3 bg-white">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center shadow-sm" style="background-color: #FFF9E6; color: #B7791F;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold" style="color: #042C53;">Update Classroom</h3>
                        <p class="text-xs font-medium" style="color: #185FA5;">Modify your classroom settings below</p>
                    </div>
                </div>

                <!-- Scrollable Form Body -->
                <div class="p-6 overflow-y-auto custom-scrollbar">
                    <form action="{{ route('classrooms.update', $classroom) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- ORIGINAL CODE PRESERVED -->
                        <div class="space-y-4">
                            @include('classrooms.partials.form', ['classroom' => $classroom])
                        </div>

                        <!-- Footer Actions -->
                        <div class="mt-8 pt-6 border-t border-gray-100 flex items-center gap-3">
                            <button type="submit"
                                    class="flex-1 px-6 py-3 rounded-xl text-white font-bold transition-all duration-200 shadow-md hover:brightness-110 active:scale-95"
                                    style="background-color: #185FA5;"
                                    onmouseover="this.style.backgroundColor='#0C447C'"
                                    onmouseout="this.style.backgroundColor='#185FA5'">
                                Save Changes
                            </button>
                            
                            <a href="{{ route('classrooms.index') }}"
                               class="px-6 py-3 rounded-xl font-bold transition-all text-gray-500 hover:bg-gray-100 text-sm">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bottom Branding -->
            <div class="mt-4 text-center">
                <span class="text-[10px] font-bold uppercase tracking-widest opacity-40" style="color: #042C53;">
                    Editing Mode: {{ $classroom->name }}
                </span>
            </div>
        </div>
    </div>

    <!-- Styles for the internal scrollbar -->
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #B5D4F4; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #185FA5; }
    </style>
</x-app-layout>