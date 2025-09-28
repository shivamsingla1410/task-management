<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 text-green-600 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filters --}}
            <div class="mb-4">
                <form method="GET" action="{{ route('tasks.index') }}" class="flex flex-wrap gap-2">
                    <select name="project_id" class="border p-2 rounded">
                        <option value="">All Projects</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->title }}
                            </option>
                        @endforeach
                    </select>

                    @if(Auth::user()->role !== 'user')
                        <select name="user_id" class="border p-2 rounded">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    <select name="status" class="border p-2 rounded">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in-progress" {{ request('status') == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
                </form>
            </div>

            @if(Auth::user()->role !== 'user')
                {{-- Create --}}
                <div class="flex justify-start mb-4">
                    <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
                        + New Task
                    </a>
                </div>
            @endif

            {{-- Table --}}
            <div class="bg-white shadow-md rounded">
                <table class="w-full border-collapse" id="tasks-table">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">Title</th>
                            <th class="border px-4 py-2">Project</th>
                            @if(Auth::user()->role !== 'user')
                                <th class="border px-4 py-2">Assigned User</th>
                            @endif
                            <th class="border px-4 py-2">Status</th>
                            <th class="border px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                            <tr id="task-{{ $task->id }}">
                                <td class="border px-4 py-2">{{ $task->title }}</td>
                                <td class="border px-4 py-2">{{ $task->project->title }}</td>
                                @if(Auth::user()->role !== 'user')
                                    <td class="border px-4 py-2">{{ $task->user?->name ?? 'Unassigned' }}</td>
                                @endif
                                <td class="border px-4 py-2 capitalize task-status">
                                    {{ ucfirst(str_replace('-', ' ', $task->status)) }}
                                </td>
                                <td class="border px-4 py-2 space-x-2">
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600">Edit</a>
                                    @if(Auth::user()->role !== 'user')
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Delete this task?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">No tasks found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $tasks->links() }}
            </div>

        </div>
    </div>
</x-app-layout>

@if(Auth::user()->role == 'user')
    
<script>
    function formatStatus(status) {
        if (!status) return "";
        // replace dashes with spaces
        let text = status.replace(/-/g, " ");
        // capitalize first letter
        return text.charAt(0).toUpperCase() + text.slice(1);
    }
    
    const editTaskUrl = "{{ url('tasks') }}";

    document.addEventListener("DOMContentLoaded", function () {
        let lastUpdatedAt = null;

        async function pollUpdates() {
            try {
                const response = await fetch(`/tasks/updates?last_updated_at=${lastUpdatedAt ?? ''}`, {
                    headers: { "X-Requested-With": "XMLHttpRequest" }
                });

                if (!response.ok) throw new Error("Network error");

                const data = await response.json();
                lastUpdatedAt = data.last_updated_at;

                if (data.tasks && data.tasks.length > 0) {
                    data.tasks.forEach(task => {
                        console.log("Task update received:", task);

                        let row = document.querySelector(`#task-${task.id}`);
                        if (row) {
                            row.querySelector('.task-status').innerText = formatStatus(task.status);
                        } else {
                            console.log('new task.');
                            
                            let table = document.querySelector('#tasks-table tbody');
                            if (table) {
                                table.innerHTML += `
                                    <tr id="task-${task.id}">
                                        <td class="border px-4 py-2">${task.title}</td>
                                        <td class="border px-4 py-2">${task.project.title}</td>
                                        <td class="border px-4 py-2 capitalize task-status">${formatStatus(task.status)}</td>
                                        <td class="border px-4 py-2 space-x-2">
                                            <a href="${editTaskUrl}/${task.id}/edit" class="text-blue-600">Edit</a>
                                        </td>
                                    </tr>`;
                            }
                        }
                    });
                }
            } catch (err) {
                console.error("Polling error:", err);
            } finally {
                // call again after 5 seconds
                setTimeout(pollUpdates, 5000);
            }
        }

        pollUpdates();
    });
</script>

@endif