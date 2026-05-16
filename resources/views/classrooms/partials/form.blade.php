<div class="mb-4">
    <label class="block text-gray-700 font-medium mb-1">Classroom Name</label>
    <input type="text" name="name" value="{{ old('name', $classroom?->name) }}"
           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
           placeholder="e.g. Grade 10 - Rizal"
           maxlength="255">
    @error('name')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 font-medium mb-1">Section</label>
    <input type="text" name="section" value="{{ old('section', $classroom?->section) }}"
           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
           placeholder="e.g. Section A"
           maxlength="255">
    @error('section')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 font-medium mb-1">Subject</label>
    <input type="text" name="subject" value="{{ old('subject', $classroom?->subject) }}"
           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
           placeholder="e.g. Mathematics"
           maxlength="255">
    @error('subject')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-6">
    <label class="block text-gray-700 font-medium mb-1">Description <span class="text-xs font-normal text-gray-400">(optional)</span></label>
    <textarea name="description" rows="4"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
              maxlength="1000"
              placeholder="Optional classroom notes...">{{ old('description', $classroom?->description) }}</textarea>
    @error('description')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
