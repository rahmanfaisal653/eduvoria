
@extends('layouts.app')

@section('title', 'Tambah Postingan')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-lg mt-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">📝 Tambah Postingan</h2>

    <form action="{{ url('/posts/store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Isi Postingan</label>
            <textarea name="isi" rows="5" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Tulis sesuatu di sini..."></textarea>
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="/profile" class="text-gray-500 hover:underline">← Batal</a>
            <button type="submit" class="bg-teal-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-teal-700 transition">
                Posting
            </button>
        </div>
    </form>
</div>
@endsection