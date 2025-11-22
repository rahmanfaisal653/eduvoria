@extends('layouts.app')

@section('title', 'Bookmark Saya - Eduvoria')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Simpanan Saya (Bookmark) 🔖</h1>

    <div class="space-y-6">
        @forelse ($bookmarks as $bookmark)
            <div class="bg-white p-5 rounded-xl shadow-lg border-l-4 border-cyan-500">
                <div class="flex justify-between items-start">
                    <div class="flex-grow">
                        <div class="flex items-center space-x-3 mb-2">
                            @if($bookmark->post->user->profile_picture)
                                <img src="{{ asset('storage/' . $bookmark->post->user->profile_picture) }}" alt="{{ $bookmark->post->user->name }}" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($bookmark->post->user->name) }}&background=F28A25&color=fff&size=40" alt="{{ $bookmark->post->user->name }}" class="h-10 w-10 rounded-full">
                            @endif
                            <div>
                                <p class="font-semibold text-gray-900">{{ $bookmark->post->user->name }}</p>
                                <p class="text-xs text-gray-500">Disimpan {{ $bookmark->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="mt-3 text-gray-700">{{ $bookmark->post->content }}</p>
                        
                        @if($bookmark->post->image)
                            <img src="{{ asset('storage/' . $bookmark->post->image) }}" 
                                 alt="Post Image" 
                                 class="mt-3 w-full rounded-lg object-cover max-h-64"/>
                        @endif

                        <div class="mt-3 text-sm text-gray-500">
                            <span>❤ {{ $bookmark->post->likes_count }} Suka</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-end space-y-1 ml-4">
                        <form action="{{ route('bookmark.toggle', $bookmark->post->id) }}" method="POST" class="bookmark-form">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700 text-lg" title="Hapus dari bookmark">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-xl shadow">
                <p class="text-gray-500 text-lg">Belum ada postingan yang di-bookmark.</p>
                <p class="text-gray-400 text-sm mt-2">Klik ikon 🔖 pada postingan untuk menyimpannya di sini.</p>
                <a href="{{ route('homepage') }}" class="inline-block mt-4 bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700">
                    Lihat Postingan
                </a>
            </div>
        @endforelse
    </div>
@endsection