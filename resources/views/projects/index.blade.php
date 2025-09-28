<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 text-green-600 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-start mb-4">
                <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
                    + Create Project
                </a>
            </div>

            <div class="bg-white shadow-md rounded">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">#</th>
                            <th class="border px-4 py-2">Title</th>
                            <th class="border px-4 py-2">Description</th>
                            <th class="border px-4 py-2">Deadline</th>
                            <th class="border px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td class="border px-4 py-2">{{ $project->id }}</td>
                                <td class="border px-4 py-2">{{ $project->title }}</td>
                                <td class="border px-4 py-2">{{ Str::limit($project->description, 50) }}</td>
                                <td class="border px-4 py-2">{{ $project->deadline }}</td>
                                <td class="border px-4 py-2 space-x-2">
                                    <a href="{{ route('projects.edit', $project->id) }}" class="text-blue-600">Edit</a>

                                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this project?')" class="text-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">No projects found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
