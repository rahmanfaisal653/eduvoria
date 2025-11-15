
@extends('layouts.app')
@section('title', 'Edit Profil')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-lg">
    <h2 class="text-xl font-bold mb-4">Edit Profil</h2>
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="nama" value="{{ $profile['nama'] }}" class="w-full border rounded-lg p-2 mt-1">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Bio</label>
            <textarea name="bio" class="w-full border rounded-lg p-2 mt-1" rows="3">{{ $profile['bio'] }}</textarea>
        </div>
        <div class="flex justify-between">
            <a href="/profile" class="text-gray-500 hover:underline">Batal</a>
            <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700">Simpan</button>
        </div>
    </form>
</div>
@endsection