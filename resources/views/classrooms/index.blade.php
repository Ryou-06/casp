<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #042C53;">
            {{ __('My Classrooms') }}
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
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
                    <h3 class="text-lg font-semibold" style="color: #042C53;">Classroom List</h3>
                    <a href="{{ route('classrooms.create') }}"
                       class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-white font-medium transition-colors duration-150"
                       style="background-color: #185FA5;"
                       onmouseover="this.style.backgroundColor='#0C447C'"
                       onmouseout="this.style.backgroundColor='#185FA5'">
                        + Create Classroom
                    </a>
                </div>

                @if($classrooms->isEmpty())
                    <div class="text-center py-12 rounded-lg" style="background-color: #E6F1FB;">
                        <p class="text-sm" style="color: #185FA5;">No classrooms created yet.</p>
                        <a href="{{ route('classrooms.create') }}" class="mt-2 inline-block font-medium" style="color: #0C447C;">
                            Create your first classroom
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full" style="border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #042C53;">
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Classroom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Subject</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Created</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #B5D4F4;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classrooms as $classroom)
                                    <tr style="border-bottom: 0.5px solid #B5D4F4;"
                                        onmouseover="this.style.backgroundColor='#E6F1FB'"
                                        onmouseout="this.style.backgroundColor='transparent'">
                                        <td class="px-6 py-4">
                                            <a href="{{ route('classrooms.show', $classroom) }}" class="text-sm font-semibold hover:underline" style="color: #042C53;">
                                                {{ $classroom->name }}
                                            </a>
                                            <div class="text-sm" style="color: #185FA5;">
                                                {{ $classroom->section ?: 'No section' }}
                                            </div>
                                            @if($classroom->description)
                                                <div class="text-xs mt-1" style="color: #6B7280;">{{ Str::limit($classroom->description, 80) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm" style="color: #185FA5;">{{ $classroom->subject ?: 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm" style="color: #185FA5;">{{ $classroom->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex gap-3">
                                                <a href="{{ route('classrooms.show', $classroom) }}" class="font-medium" style="color: #185FA5;">Open</a>
                                                <a href="{{ route('classrooms.edit', $classroom) }}" class="font-medium" style="color: #B7791F;">Edit</a>
                                                <form action="{{ route('classrooms.destroy', $classroom) }}" method="POST" onsubmit="return confirm('Delete this classroom?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium" style="color: #A32D2D;">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $classrooms->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
