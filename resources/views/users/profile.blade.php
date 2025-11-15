
@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="h-40 bg-gradient-to-r from-teal-500 to-cyan-500"></div>

    <div class="relative px-6 pb-6">
        <div class="absolute -top-16 left-6 h-24 w-24 rounded-full border-4 border-white bg-orange-400 flex-shrink-0"></div>

        <div class="flex flex-col sm:flex-row sm:items-end pt-10 sm:pt-0">
            <div class="sm:ml-28 mt-2 sm:mt-0 flex-grow">
                <h1 class="text-2xl font-bold text-gray-900">{{$profiles['nama']}}</h1>
                @foreach ($profiles['hobi'] as $hobi)
                    <p class="text-sm text-gray-600 inline">{{ $hobi }}@if(!$loop->last) | @endif</p>
                @endforeach
                <p class="text-gray-700 mt-2 text-sm max-w-xl">
                    {{ $profiles['bio'] }}
                </p>
            </div>

            <div class="mt-4 sm:mt-0 flex space-x-2 flex-shrink-0">
                <!-- Ganti tombol kelola profil ke route CRUD -->
                <a href="{{ route('profile.edit') }}" 
                   class="border border-gray-300 text-gray-700 py-2 px-4 rounded-full text-sm font-semibold hover:bg-gray-100 transition">
                    Kelola Profil
                </a>
            </div>
        </div>

        <div class="mt-6 border-t border-gray-100 pt-4 flex justify-start space-x-8 text-center sm:text-left">
            <div>
                <p class="text-xl font-bold text-gray-900">{{$profiles['pengikut']}}</p>
                <p class="text-sm text-gray-500">Pengikut</p>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{$profiles['mengikuti']}}</p>
                <p class="text-sm text-gray-500">Mengikuti</p>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $profiles['postingan'] }}</p>
                <p class="text-sm text-gray-500">Postingan</p>
            </div>
        </div>
    </div>
</div>

{{-- POSTINGAN --}}
<div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- Tombol tambah postingan -->
    <div class="lg:col-span-2 flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Postingan Saya</h2>
        <a href="{{ route('posts.create') }}" 
           class="bg-teal-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-teal-700">
            + Tambah Postingan
        </a>
    </div>

    @foreach ($profilePosts as $value)
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-xl bg-white p-5 shadow-lg relative">

                <!-- Tombol edit dan hapus -->
                <div class="absolute top-4 right-4 flex space-x-2">
                    <a href="{{ route('posts.edit', $value['id']) }}" 
                       class="text-blue-600 hover:text-blue-800 text-sm font-semibold">✏ Edit</a>
                    <form action="{{ route('posts.destroy', $value['id']) }}" method="POST" onsubmit="return confirm('Yakin hapus postingan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">🗑 Hapus</button>
                    </form>
                </div>

                <div class="flex justify-between items-start">
                    <a href="#" class="flex items-center space-x-3 hover:opacity-80 transition">
                        <div class="h-10 w-10 rounded-full bg-orange-400 flex-shrink-0"></div>
                        <div>
                            <p class="font-semibold text-gray-900">{{$value['nama']}}</p>
                            <p class="text-xs text-gray-500">{{ $value['waktu'] }} jam yang lalu</p>
                        </div>
                    </a>
                </div>

                <p class="mt-3 text-gray-700">{{ $value['isi'] }}</p>
                <img src="https://via.placeholder.com/600x350/F28A25/ffffff?text=Kopi+Sore" 
                     alt="Post Image" 
                     class="mt-3 w-full rounded-lg object-cover"/>

                <div class="mt-4 flex justify-between border-t border-gray-100 pt-3 text-sm text-gray-500">
                    <div class="flex space-x-4">
                        <span class="cursor-pointer hover:text-red-500">❤ {{ $value['like'] }} Suka</span>
                        <span class="cursor-pointer hover:text-teal-600">💬 {{ $value['komentar'] }} Komentar</span>
                    </div>
                    <div class="flex space-x-3">
                        <span class="cursor-pointer hover:text-teal-600">🔖 Bookmark</span>
                        <span class="cursor-pointer hover:text-teal-600">↗ Bagikan</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection