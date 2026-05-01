<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #042C53;">
            {{ __('Create Classroom') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('classrooms.store') }}" method="POST">
                        @csrf

                        @include('classrooms.partials.form', ['classroom' => null])

                        <div class="flex gap-3">
                            <button type="submit"
                                    class="px-6 py-2 rounded-lg text-white font-medium transition-colors duration-150"
                                    style="background-color: #185FA5;"
                                    onmouseover="this.style.backgroundColor='#0C447C'"
                                    onmouseout="this.style.backgroundColor='#185FA5'">
                                Create Classroom
                            </button>
                            <a href="{{ route('classrooms.index') }}"
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
