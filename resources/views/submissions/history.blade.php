<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #042C53;">
            All Submissions History
        </h2>
    </x-slot>

    <div class="w-full" style="background-color: #F4F7FB; min-height: 100vh; padding: 1.5rem;">
        <div class="overflow-hidden sm:rounded-lg" style="background-color: #fff; border: 0.5px solid #B5D4F4;">
            <div class="p-6">

                <div class="mb-5">
                    <a href="{{ route('assignments.index') }}" 
                       class="text-sm font-medium transition-colors duration-150"
                       style="color: #185FA5;"
                       onmouseover="this.style.color='#042C53'"
                       onmouseout="this.style.color='#185FA5'">
                        ← Back to Assignments
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 px-4 py-3 rounded-lg text-sm" style="background-color: #E1F5EE; border: 1px solid #1D9E75; color: #085041;">
                        {{ session('success') }}
                    </div>
                @endif

                @if($submissions->isEmpty())
                    <div class="text-center py-12 rounded-lg" style="background-color: #E6F1FB;">
                        <p class="text-sm" style="color: #185FA5;">No submissions received yet.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full" style="border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #042C53;">
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Assignment</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Student</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">File</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Submitted</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissions as $index => $submission)
                                    <tr style="border-bottom: 0.5px solid #B5D4F4;" 
                                        onmouseover="this.style.backgroundColor='#E6F1FB'"
                                        onmouseout="this.style.backgroundColor='transparent'">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: #185FA5;">
                                            {{ $submissions->firstItem() + $index }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium" style="color: #042C53;">{{ $submission->assignment->title }}</div>
                                            <div class="text-xs mt-0.5" style="color: #378ADD;">{{ $submission->assignment->subject }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium" style="color: #042C53;">{{ $submission->student->name }}</div>
                                            <div class="text-xs mt-0.5" style="color: #378ADD;">{{ $submission->student->email }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm break-all" style="color: #042C53;">{{ $submission->file_name }}</div>
                                            <div class="text-xs mt-0.5" style="color: #378ADD;">{{ $submission->formatted_file_size }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: #185FA5;">
                                            {{ $submission->submitted_at->format('M d, Y h:i A') }}<br>
                                            <span class="text-xs" style="color: #378ADD;">{{ $submission->submitted_at->diffForHumans() }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ Storage::url($submission->file_path) }}" 
                                               target="_blank"
                                               class="px-3 py-1 rounded text-xs font-medium transition-colors duration-150"
                                               style="background-color: #E6F1FB; color: #0C447C; border: 1px solid #B5D4F4;"
                                               onmouseover="this.style.backgroundColor='#185FA5';this.style.color='white'"
                                               onmouseout="this.style.backgroundColor='#E6F1FB';this.style.color='#0C447C'">
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $submissions->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>