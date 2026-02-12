@extends('Layout.Dashboard')

@section('content')
<div class="p-8 max-w-lg">
    <h1 class="text-2xl font-bold text-blue-900 mb-6">Tambah User</h1>

    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow">
        @csrf

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Nama Lengkap</label>
            <input type="text" name="name" class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Username</label>
            <input type="text" name="username" class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Password</label>
            <input type="password" name="password" class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Role</label>
            <select name="role_id" class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="">Pilih Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border rounded hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
