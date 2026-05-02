<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl tracking-tight" style="color: #042C53;">
                {{ __('My Classrooms') }}
            </h2>
            <div class="hidden sm:block text-sm font-medium px-3 py-1 rounded-full bg-white shadow-sm border border-blue-100" style="color: #185FA5;">
                Teacher Management Portal
            </div>
        </div>
    </x-slot>

    <div class="w-full" style="background-color: #F4F7FB; min-height: 100vh; padding: 2rem 1.5rem;">
        <div class="max-w-7xl mx-auto">
            
            @if(session('success'))
                <div class="mb-6 px-4 py-3 rounded-xl text-sm font-semibold shadow-sm flex items-center border-l-4" 
                     style="background-color: #E1F5EE; border-color: #1D9E75; color: #085041;">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden sm:rounded-2xl shadow-sm bg-white" style="border: 1px solid #B5D4F4;">
                <div class="p-0">
                    <!-- Table Header Action Area -->
                    <div class="p-6 border-b border-gray-100 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white">
                        <div>
                            <h3 class="text-xl font-bold" style="color: #042C53;">Classroom List</h3>
                            <p class="text-sm font-medium" style="color: #185FA5;">Manage your active student groups and subjects</p>
                        </div>
                        <a href="{{ route('classrooms.create') }}"
                           class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-white font-bold transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-md"
                           style="background-color: #185FA5;">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Classroom
                        </a>
                    </div>

                    @if($classrooms->isEmpty())
                        <div class="text-center py-20 bg-gray-50">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4" style="background-color: #E6F1FB;">
                                <svg class="w-8 h-8" style="color: #185FA5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <p class="text-lg font-semibold" style="color: #042C53;">No classrooms created yet</p>
                            <p class="text-sm mb-6" style="color: #185FA5;">Get started by setting up your first virtual classroom.</p>
                            <a href="{{ route('classrooms.create') }}" class="font-bold underline hover:no-underline" style="color: #0C447C;">
                                Create your first classroom &rarr;
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full border-separate border-spacing-0">
                                <thead>
                                    <tr style="background-color: #F8FAFC;">
                                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest border-b border-gray-100" style="color: #042C53;">Classroom Detail</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest border-b border-gray-100" style="color: #042C53;">Subject</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest border-b border-gray-100" style="color: #042C53;">Created Date</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-widest border-b border-gray-100" style="color: #042C53;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($classrooms as $classroom)
                                        <tr class="transition-colors duration-150 hover:bg-blue-50/30">
                                            <td class="px-6 py-5">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 shadow-sm" style="background-color: #E6F1FB; color: #185FA5;">
                                                        <span class="font-bold text-sm">{{ strtoupper(substr($classroom->name, 0, 1)) }}</span>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('classrooms.show', $classroom) }}" class="text-sm font-bold hover:underline block" style="color: #042C53;">
                                                            {{ $classroom->name }}
                                                        </a>
                                                        <div class="text-xs font-medium" style="color: #185FA5;">
                                                            Section: {{ $classroom->section ?: 'Unassigned' }}
                                                        </div>
                                                        @if($classroom->description)
                                                            <div class="text-xs mt-1 italic text-gray-500 max-w-xs truncate">{{ $classroom->description }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <span class="px-3 py-1 rounded-full text-xs font-bold border" style="background-color: #F0F7FF; border-color: #B5D4F4; color: #0C447C;">
                                                    {{ $classroom->subject ?: 'General' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5 text-sm font-medium text-gray-600">
                                                {{ $classroom->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-5">
                                                <div class="flex justify-end items-center gap-4">
                                                    <a href="{{ route('classrooms.show', $classroom) }}" class="text-xs font-bold uppercase hover:opacity-70" style="color: #185FA5;">Open</a>
                                                    <a href="{{ route('classrooms.edit', $classroom) }}" class="text-xs font-bold uppercase hover:opacity-70" style="color: #B7791F;">Edit</a>
                                                    <form action="{{ route('classrooms.destroy', $classroom) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this classroom?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-xs font-bold uppercase hover:opacity-70" style="color: #A32D2D;">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="p-6 border-t border-gray-100 bg-gray-50/50">
                            {{ $classrooms->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>