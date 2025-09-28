@csrf

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Name</label>
    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Email</label>
    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Role</label>
    <select name="role"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        <option value="user" {{ old('role', $user->role ?? '') === 'user' ? 'selected' : '' }}>User</option>
        <option value="manager" {{ old('role', $user->role ?? '') === 'manager' ? 'selected' : '' }}>Manager</option>
        <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
    @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Password @if(isset($user) && $user->password) (leave blank to keep) @endif</label>
    <input type="password" name="password"
           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
    <input type="password" name="password_confirmation"
           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
</div>

<div class="flex justify-end">
    <a href="{{ route('users.index') }}" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">Cancel</a>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
</div>
