<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #042C53;">
            {{ __('My Classrooms') }}
        </h2>
    </x-slot>

    <div class="w-full" style="background-color: #F4F7FB; min-height: 100vh; padding: 1.5rem;">
        <div class="overflow-hidden sm:rounded-lg" style="background-color: #fff; border: 0.5px solid #B5D4F4;">
            <div class="p-6">
                @if($classrooms->isEmpty())
                    <div class="text-center py-12 rounded-lg" style="background-color: #E6F1FB;">
                        <p class="text-sm" style="color: #185FA5;">You are not enrolled in any classroom yet.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($classrooms as $classroom)
                            <a href="{{ route('student.classrooms.show', $classroom) }}"
                               class="block p-5 rounded-lg transition"
                               style="background-color: #F4F7FB; border: 0.5px solid #B5D4F4;">
                                <h3 class="font-semibold" style="color: #042C53;">{{ $classroom->name }}</h3>
                                <p class="text-sm mt-1" style="color: #185FA5;">{{ $classroom->subject ?: 'No subject' }}</p>
                                <p class="text-xs mt-3" style="color: #378ADD;">{{ $classroom->assignments_count }} posted activit{{ $classroom->assignments_count === 1 ? 'y' : 'ies' }}</p>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $classrooms->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
