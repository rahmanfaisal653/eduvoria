
@extends('layouts.app')
@section('title', 'Edit Profil')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-lg mt-6">
    <h2 class="text-xl font-bold mb-4">Edit Profil</h2>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        @if($user->profile_picture)
        <div class="mb-4 flex justify-center">
            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="w-24 h-24 rounded-full object-cover">
        </div>
        @endif

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Foto Profil (Opsional)</label>
            <input type="file" name="profile_picture" accept="image/*" class="w-full border rounded-lg p-2 mt-1">
            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded-lg p-2 mt-1" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Bio</label>
            <textarea name="bio" class="w-full border rounded-lg p-2 mt-1" rows="3">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Hobi</label>
            <input type="text" name="hobi" value="{{ old('hobi', $user->hobi) }}" class="w-full border rounded-lg p-2 mt-1" placeholder="Contoh: Membaca, Olahraga, Coding">
        </div>

        <div class="flex justify-between">
            <a href="{{ route('profile') }}" class="text-gray-500 hover:underline">Batal</a>
            <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700">Simpan</button>
        </div>
    </form>
</div>
@endsection