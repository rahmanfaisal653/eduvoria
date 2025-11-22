
@extends('layouts.app')

@section('title', 'Edit Postingan')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-lg mt-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">✏ Edit Postingan</h2>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Isi Postingan</label>
            <textarea name="content" rows="5" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-teal-500" required>{{ old('content', $post->content) }}</textarea>
        </div>

        @if($post->image)
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Saat Ini</label>
            <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image" class="w-32 h-32 object-cover rounded-lg">
        </div>
        @endif

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Ubah Foto (Opsional)</label>
            <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-teal-500">
            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('profile') }}" class="text-gray-500 hover:underline">← Kembali</a>
            <button type="submit" class="bg-teal-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-teal-700 transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection