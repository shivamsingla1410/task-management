@csrf
<div class="mb-4">
    <label class="block font-medium">Title</label>
    <input type="text" name="title" value="{{ old('title', $task->title ?? '') }}"
           class="w-full border rounded p-2">
</div>

<div class="mb-4">
    <label class="block font-medium">Description</label>
    <textarea name="description" class="w-full border rounded p-2">{{ old('description', $task->description ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label class="block font-medium">Project</label>
    <select name="project_id" class="w-full border rounded p-2">
        @foreach($projects as $project)
            <option value="{{ $project->id }}" {{ old('project_id', $task->project_id ?? '') == $project->id ? 'selected' : '' }}>
                {{ $project->title }}
            </option>
        @endforeach
    </select>
</div>

@if(Auth::user()->role !== 'user')
<div class="mb-4">
    <label class="block font-medium">Assign To</label>
    <select name="user_id" class="w-full border rounded p-2">
        <option value="">Unassigned</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id', $task->user_id ?? '') == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
</div>
@endif

<div class="mb-4">
    <label class="block font-medium">Status</label>
    <select name="status" class="w-full border rounded p-2">
        <option value="pending" {{ old('status', $task->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="in-progress" {{ old('status', $task->status ?? '') == 'in-progress' ? 'selected' : '' }}>In Progress</option>
        <option value="completed" {{ old('status', $task->status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
    </select>
</div>

<div class="flex justify-end">
    <a href="{{ route('tasks.index') }}" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">Cancel</a>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        {{ $buttonText }}
    </button>
</div>
