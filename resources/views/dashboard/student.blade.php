<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #042C53;">
            {{ __('My Classrooms') }}
        </h2>
    </x-slot>

    <div class="w-full" style="background-color: #F4F7FB; min-height: 100vh; padding: 1.5rem;">
        @if($classrooms->isEmpty())
            <div class="overflow-hidden sm:rounded-lg" style="background-color: #fff; border: 0.5px solid #B5D4F4;">
                <div class="p-10 text-center">
                    <h3 class="text-lg font-semibold" style="color: #042C53;">No classrooms yet</h3>
                    <p class="text-sm mt-2" style="color: #185FA5;">Your enrolled classrooms will appear here once your teacher adds you.</p>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($classrooms as $classroom)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="border: 0.5px solid #B5D4F4;">
                        <div class="h-2" style="background-color: #185FA5;"></div>

                        <div class="p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <h3 class="text-lg font-semibold leading-snug" style="color: #042C53;">
                                        {{ $classroom->name }}
                                    </h3>
                                    <p class="text-sm mt-1" style="color: #185FA5;">
                                        {{ $classroom->subject ?: 'No subject' }}
                                        @if($classroom->section)
                                            <span style="color: #85B7EB;">/</span> {{ $classroom->section }}
                                        @endif
                                    </p>
                                </div>

                                <div class="w-11 h-11 rounded-lg flex items-center justify-center shrink-0 font-semibold"
                                     style="background-color: #E6F1FB; color: #0C447C;">
                                    {{ strtoupper(substr($classroom->name, 0, 1)) }}
                                </div>
                            </div>

                            <div class="mt-5 flex items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-sm truncate" style="color: #374151;">{{ $classroom->teacher?->name ?? 'Teacher' }}</p>
                                    <p class="text-xs mt-1" style="color: #378ADD;">
                                        {{ $classroom->assignments_count }} activit{{ $classroom->assignments_count === 1 ? 'y' : 'ies' }}
                                    </p>
                                </div>

                                <a href="{{ route('student.classrooms.show', $classroom) }}"
                                   class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-medium text-white"
                                   style="background-color: #185FA5;">
                                    Enter
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
