<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    @include('users.form', ['user' => $user])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
