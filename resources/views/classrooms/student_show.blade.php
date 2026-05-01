<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #042C53;">
            {{ $classroom->name }}
        </h2>
    </x-slot>

    <div class="w-full" style="background-color: #F4F7FB; min-height: 100vh; padding: 1.5rem;">
        <div class="max-w-5xl mx-auto space-y-6">
            <div class="overflow-hidden sm:rounded-lg" style="background-color: #fff; border: 0.5px solid #B5D4F4;">
                <div class="p-6">
                    <h3 class="text-lg font-semibold" style="color: #042C53;">{{ $classroom->name }}</h3>
                    <p class="text-sm mt-1" style="color: #185FA5;">Section: {{ $classroom->section ?: 'N/A' }}</p>
                    <p class="text-sm mt-1" style="color: #185FA5;">Subject: {{ $classroom->subject ?: 'N/A' }}</p>
                    @if($classroom->description)
                        <p class="text-sm mt-3" style="color: #4B5563;">{{ $classroom->description }}</p>
                    @endif
                </div>
            </div>

            <div class="overflow-hidden sm:rounded-lg" style="background-color: #fff; border: 0.5px solid #B5D4F4;">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4" style="color: #042C53;">Activities</h3>

                    @if($classroom->assignments->isEmpty())
                        <div class="text-center py-10 rounded-lg" style="background-color: #E6F1FB; color: #185FA5;">
                            No activities posted yet.
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($classroom->assignments as $assignment)
                                <div class="p-4 rounded-lg" style="background-color: #F4F7FB; border: 0.5px solid #B5D4F4;">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <p class="font-semibold" style="color: #042C53;">{{ $assignment->title }}</p>
                                            <p class="text-sm" style="color: #185FA5;">Due: {{ $assignment->due_date->format('M d, Y h:i A') }}</p>
                                            <p class="text-sm mt-2" style="color: #4B5563;">{{ Str::limit($assignment->description, 120) }}</p>
                                        </div>
                                        @if(!$assignment->isPastDue())
                                            <a href="{{ route('submissions.create', $assignment) }}"
                                               class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-white text-sm font-medium"
                                               style="background-color: #185FA5;">
                                                Submit
                                            </a>
                                        @else
                                            <span class="text-xs px-2 py-1 rounded" style="background-color: #FCEBEB; color: #A32D2D;">Closed</span>
                                        @endif
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
