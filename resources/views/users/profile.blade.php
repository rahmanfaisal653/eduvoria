
@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="h-40 bg-gradient-to-r from-teal-500 to-cyan-500"></div>

    <div class="relative px-6 pb-6">
        @if($user->profile_picture)
            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="absolute -top-16 left-6 h-24 w-24 rounded-full border-4 border-white object-cover">
        @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=F28A25&color=fff&size=96" alt="{{ $user->name }}" class="absolute -top-16 left-6 h-24 w-24 rounded-full border-4 border-white">
        @endif

        <div class="flex flex-col sm:flex-row sm:items-end pt-10 sm:pt-0">
            <div class="sm:ml-28 mt-2 sm:mt-0 flex-grow">
                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                @if($user->hobi)
                    <p class="text-sm text-gray-600">{{ $user->hobi }}</p>
                @endif
                @if($user->bio)
                    <p class="text-gray-700 mt-2 text-sm max-w-xl">{{ $user->bio }}</p>
                @endif
            </div>

            <div class="mt-4 sm:mt-0 flex space-x-2 flex-shrink-0">
                <a href="{{ route('profile.edit') }}" 
                   class="border border-gray-300 text-gray-700 py-2 px-4 rounded-full text-sm font-semibold hover:bg-gray-100 transition">
                    Kelola Profil
                </a>
            </div>
        </div>

        <div class="mt-6 border-t border-gray-100 pt-4 flex justify-start space-x-8 text-center sm:text-left">
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $user->followers_count }}</p>
                <p class="text-sm text-gray-500">Pengikut</p>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $user->following_count }}</p>
                <p class="text-sm text-gray-500">Mengikuti</p>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $posts->count() }}</p>
                <p class="text-sm text-gray-500">Postingan</p>
            </div>
        </div>
    </div>
</div>


<div class="mt-8">
    <!-- Tombol tambah postingan -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Postingan Saya</h2>
        <a href="{{ route('posts.create') }}" 
           class="bg-teal-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-teal-700">
            + Tambah Postingan
        </a>
    </div>

    @forelse ($posts as $post)
        <div class="mb-6">
            <div class="rounded-xl bg-white p-5 shadow-lg relative">

                <!-- Tombol edit dan hapus -->
                <div class="absolute top-4 right-4 flex space-x-2">
                    <a href="{{ route('posts.edit', $post->id) }}" 
                       class="text-blue-600 hover:text-blue-800 text-sm font-semibold">✏ Edit</a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Yakin hapus postingan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">🗑 Hapus</button>
                    </form>
                </div>

                <div class="flex justify-between items-start">
                    <div class="flex items-center space-x-3">
                        @if($post->user->profile_picture)
                            <img src="{{ asset('storage/' . $post->user->profile_picture) }}" alt="{{ $post->user->name }}" class="h-10 w-10 rounded-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=F28A25&color=fff&size=40" alt="{{ $post->user->name }}" class="h-10 w-10 rounded-full">
                        @endif
                        <div>
                            <p class="font-semibold text-gray-900">{{ $post->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <p class="mt-3 text-gray-700">{{ $post->content }}</p>
                
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" 
                         alt="Post Image" 
                         class="mt-3 w-full rounded-lg object-cover max-h-96"/>
                @endif

                <div class="mt-4 flex justify-between border-t border-gray-100 pt-3 text-sm text-gray-500">
                    <div class="flex space-x-4">
                        <span class="cursor-pointer hover:text-red-500">❤ {{ $post->likes_count }} Suka</span>
                    </div>
                    <div class="flex space-x-3">
                        <form action="{{ route('bookmark.toggle', $post->id) }}" method="POST" class="inline bookmark-form">
                            @csrf
                            <button type="submit" class="cursor-pointer hover:text-teal-600">
                                🔖 Bookmark
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12 bg-white rounded-xl shadow">
            <p class="text-gray-500">Belum ada postingan. Yuk buat postingan pertamamu!</p>
            <a href="{{ route('posts.create') }}" class="inline-block mt-4 bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700">
                Buat Postingan
            </a>
        </div>
    @endforelse
</div>

@endsection