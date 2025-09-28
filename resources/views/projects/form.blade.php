@csrf

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Title</label>
    <input type="text" name="title" value="{{ old('title', $project->title ?? '') }}"
           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Description</label>
    <textarea name="description" rows="4"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $project->description ?? '') }}</textarea>
    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Deadline</label>
    <input type="date" name="deadline" value="{{ old('deadline', $project->deadline ?? '') }}"
           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    @error('deadline') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>

<div class="flex justify-end">
    <a href="{{ route('projects.index') }}" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">Cancel</a>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
</div>
