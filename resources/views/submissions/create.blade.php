<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submit Assignment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Assignment Details --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $assignment->title }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Subject: {{ $assignment->subject }}</p>
                    <p class="text-sm mt-1 {{ $assignment->isPastDue() ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                        Due: {{ $assignment->due_date->format('M d, Y h:i A') }}
                    </p>
                    <p class="text-gray-700 mt-3">{{ $assignment->description }}</p>
                </div>
            </div>

            {{-- Upload Form --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if($existing)
                        <div class="mb-4 bg-yellow-50 border border-yellow-300 text-yellow-800 px-4 py-3 rounded">
                            You already submitted: <strong>{{ $existing->file_name }}</strong>
                            on {{ $existing->submitted_at->format('M d, Y h:i A') }}.
                            Uploading a new file will replace your previous submission.
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('submissions.store', $assignment) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-1">Upload File</label>
                            <input type="file" name="file"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-sm text-gray-500 mt-1">
                                Accepted: PDF, Word, Excel, PowerPoint, TXT, ZIP, RAR, JPG, PNG. Max size: 500MB.
                            </p>
                            @error('file')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-3">
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                                {{ $existing ? 'Re-submit' : 'Submit Assignment' }}
                            </button>
                            <a href="{{ route('submissions.index') }}"
                               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>