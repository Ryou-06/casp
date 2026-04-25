<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #042C53;">
            {{ __('Assignments') }}
        </h2>
    </x-slot>

    <div class="w-full" style="background-color: #F4F7FB; min-height: 100vh; padding: 1.5rem;">

        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded-lg text-sm" style="background-color: #E1F5EE; border: 1px solid #1D9E75; color: #085041;">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden sm:rounded-lg" style="background-color: #fff; border: 0.5px solid #B5D4F4;">
            <div class="p-6">
                @if($assignments->isEmpty())
                    <div class="text-center py-12 rounded-lg" style="background-color: #E6F1FB;">
                        <p class="text-sm" style="color: #185FA5;">No assignments available yet.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full" style="border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #042C53;">
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Subject</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Due Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignments as $assignment)
                                    <tr style="border-bottom: 0.5px solid #B5D4F4;"
                                        onmouseover="this.style.backgroundColor='#E6F1FB'"
                                        onmouseout="this.style.backgroundColor='transparent'">
                                        <td class="px-6 py-4 text-sm font-medium" style="color: #042C53;">{{ $assignment->title }}</td>
                                        <td class="px-6 py-4 text-sm" style="color: #185FA5;">{{ $assignment->subject }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span style="color: {{ $assignment->isPastDue() ? '#A32D2D' : '#185FA5' }}; font-weight: {{ $assignment->isPastDue() ? '600' : '400' }};">
                                                {{ $assignment->due_date->format('M d, Y h:i A') }}
                                                @if($assignment->isPastDue())
                                                    <span class="text-xs px-2 py-0.5 rounded ml-1" style="background-color: #FCEBEB; color: #A32D2D;">Past Due</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($assignment->submissions_exists)
                                                <span class="text-xs px-2 py-1 rounded-full font-semibold" style="background-color: #E1F5EE; color: #0F6E56;">
                                                    Submitted
                                                </span>
                                            @else
                                                <span class="text-xs px-2 py-1 rounded-full font-semibold" style="background-color: #FAEEDA; color: #854F0B;">
                                                    Not Submitted
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if(!$assignment->isPastDue())
                                                <a href="{{ route('submissions.create', $assignment) }}"
                                                   class="px-3 py-1 rounded text-xs font-medium text-white transition-colors duration-150"
                                                   style="background-color: #185FA5;"
                                                   onmouseover="this.style.backgroundColor='#042C53'"
                                                   onmouseout="this.style.backgroundColor='#185FA5'">
                                                    {{ $assignment->submissions_exists ? 'Re-upload' : 'Submit' }}
                                                </a>
                                            @else
                                                <span class="text-xs" style="color: #B5D4F4;">Closed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $assignments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>