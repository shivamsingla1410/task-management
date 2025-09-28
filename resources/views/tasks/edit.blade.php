<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white shadow-md rounded p-6">
            <form method="POST" action="{{ route('tasks.update', $task) }}">
                @csrf
                @method('PUT')
                @include('tasks.form', ['buttonText' => 'Update Task'])
            </form>
        </div>
    </div>
</x-app-layout>
