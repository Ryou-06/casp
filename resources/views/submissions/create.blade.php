<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #042C53;">
            {{ __('Submit Assignment') }}
        </h2>
    </x-slot>

    <div class="w-full" style="background-color: #F4F7FB; min-height: 100vh; padding: 1.5rem;">
        <div class="max-w-3xl mx-auto space-y-4">

            {{-- Assignment Details --}}
            <div class="overflow-hidden sm:rounded-lg" style="background-color: #fff; border: 0.5px solid #B5D4F4;">
                <div class="p-5" style="border-left: 4px solid #185FA5;">
                    <h3 class="text-lg font-semibold" style="color: #042C53;">{{ $assignment->title }}</h3>
                    <p class="text-sm mt-1" style="color: #378ADD;">Subject: {{ $assignment->subject }}</p>
                    <p class="text-sm mt-1 {{ $assignment->isPastDue() ? 'font-semibold' : '' }}"
                       style="color: {{ $assignment->isPastDue() ? '#A32D2D' : '#185FA5' }};">
                        Due: {{ $assignment->due_date->format('M d, Y h:i A') }}
                    </p>
                    <p class="text-sm mt-3" style="color: #042C53;">{{ $assignment->description }}</p>
                </div>
            </div>

            {{-- Upload Form --}}
            <div class="overflow-hidden sm:rounded-lg" style="background-color: #fff; border: 0.5px solid #B5D4F4;">
                <div class="p-6">

                    @if($existing)
                        <div class="mb-4 px-4 py-3 rounded-lg text-sm" style="background-color: #FAEEDA; border: 1px solid #EF9F27; color: #633806;">
                            You already submitted: <strong>{{ $existing->file_name }}</strong>
                            on {{ $existing->submitted_at->format('M d, Y h:i A') }}.
                            Uploading a new file will replace your previous submission.
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 px-4 py-3 rounded-lg text-sm" style="background-color: #FCEBEB; border: 1px solid #E24B4A; color: #791F1F;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('submissions.store', $assignment) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2" style="color: #042C53;">Upload File</label>
                            <input type="file" name="file"
                                   class="w-full rounded-lg px-3 py-2 text-sm"
                                   style="border: 1px solid #B5D4F4; color: #042C53; background-color: #F4F7FB; outline: none;">
                            <p class="text-xs mt-2" style="color: #378ADD;">
                                Accepted: PDF, Word, Excel, PowerPoint, TXT, ZIP, RAR, JPG, PNG. Max size: 500MB.
                            </p>
                            @error('file')
                                <p class="text-xs mt-1" style="color: #A32D2D;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-3">
                            <button type="submit"
                                    class="px-6 py-2 rounded-lg text-white text-sm font-medium transition-colors duration-150"
                                    style="background-color: #185FA5;"
                                    onmouseover="this.style.backgroundColor='#042C53'"
                                    onmouseout="this.style.backgroundColor='#185FA5'">
                                {{ $existing ? 'Re-submit' : 'Submit Assignment' }}
                            </button>
                            <a href="{{ route('submissions.index') }}"
                               class="px-6 py-2 rounded-lg text-sm font-medium transition-colors duration-150"
                               style="background-color: #E6F1FB; color: #0C447C; border: 1px solid #B5D4F4;"
                               onmouseover="this.style.backgroundColor='#B5D4F4'"
                               onmouseout="this.style.backgroundColor='#E6F1FB'">
                                Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>