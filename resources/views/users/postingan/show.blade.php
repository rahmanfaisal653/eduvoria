@extends('layouts.app')

@section('title', 'Detail Postingan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <!-- Tombol Kembali -->
        <div class="mb-4">
            <a href="{{ url()->previous() }}" class="text-teal-600 hover:text-teal-700 font-semibold">
                ← Kembali
            </a>
        </div>

        <!-- Post Card Detail -->
        <div class="rounded-xl bg-white p-6 shadow-lg">
            <!-- Header Post -->
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center space-x-3">
                    @if($post->user->profile_picture)
                        <img src="{{ asset('storage/' . $post->user->profile_picture) }}" 
                             alt="{{ $post->user->name }}" 
                             class="h-12 w-12 rounded-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=F28A25&color=fff&size=48" 
                             alt="{{ $post->user->name }}" 
                             class="h-12 w-12 rounded-full">
                    @endif
                    <div>
                        <p class="font-bold text-gray-900 text-lg">{{ $post->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $post->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                @auth
                @if($post->user_id === Auth::id())
                <div class="flex space-x-2">
                    <a href="{{ route('posts.edit', $post->id) }}" 
                       class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('posts.destroy', $post->id) }}" 
                          method="POST" 
                          class="inline"
                          onsubmit="return confirm('Yakin ingin menghapus postingan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-semibold">
                            🗑️ Hapus
                        </button>
                    </form>
                </div>
                @endif
                @endauth
            </div>

            <!-- Content -->
            <div class="mb-4">
                <p class="text-gray-800 text-base leading-relaxed whitespace-pre-wrap">{{ $post->content }}</p>
            </div>

            <!-- Image -->
            @if($post->image)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $post->image) }}" 
                         alt="Post Image" 
                         class="w-full rounded-lg object-cover"/>
                </div>
            @endif

            <!-- Stats -->
            <div class="flex items-center space-x-6 text-sm text-gray-500 border-t border-gray-100 pt-4">
                <span class="flex items-center space-x-1">
                    <span>❤</span>
                    <span class="font-semibold">{{ $post->likes_count }}</span>
                    <span>Suka</span>
                </span>
                <span class="flex items-center space-x-1">
                    <span>💬</span>
                    <span class="font-semibold">{{ $post->replies->count() }}</span>
                    <span>Balasan</span>
                </span>
                <span class="flex items-center space-x-1">
                    <span>👁</span>
                    <span class="font-semibold">{{ $post->views }}</span>
                    <span>Views</span>
                </span>
                <span class="flex items-center space-x-1">
                    <span>🔖</span>
                    <span class="font-semibold">{{ $post->bookmarks_count ?? 0 }}</span>
                    <span>Bookmark</span>
                </span>
            </div>

            <!-- Like & Bookmark Buttons -->
            <div class="border-t border-gray-100 mt-4 pt-4 flex items-center space-x-3">
                @auth
                    <?php 
                        $sudahLike = \App\Models\Like::where('user_id', Auth::id())
                                                     ->where('post_id', $post->id)
                                                     ->exists();
                        $sudahBookmark = \App\Models\Bookmark::where('user_id', Auth::id())
                                                            ->where('post_id', $post->id)
                                                            ->exists();
                    ?>
                    
                    <!-- Like Button -->
                    <form action="{{ route('like.toggle', $post->id) }}" method="POST">
                        @csrf
                        @if($sudahLike)
                            <button type="submit" class="flex items-center space-x-2 px-4 py-2 bg-red-50 border-2 border-red-500 rounded-lg hover:bg-red-100 transition">
                                <!-- Icon Heart Filled (Merah) -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="#EF4444">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                <span class="font-semibold text-red-600">Disukai</span>
                            </button>
                        @else
                            <button type="submit" class="flex items-center space-x-2 px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition">
                                <!-- Icon Heart Outline (Kosong) -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                <span class="font-semibold text-gray-700">Suka</span>
                            </button>
                        @endif
                    </form>

                    <!-- Bookmark Button -->
                    @if($post->user_id != Auth::id())
                        <form action="{{ route('bookmark.toggle', $post->id) }}" method="POST">
                            @csrf
                            @if($sudahBookmark)
                                <button type="submit" class="flex items-center space-x-2 px-4 py-2 bg-red-50 border-2 border-red-500 rounded-lg hover:bg-red-100 transition">
                                    <!-- Icon Bookmark Filled (Merah) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="#EF4444">
                                        <path d="M5 5c0-1.1.9-2 2-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                    </svg>
                                    <span class="font-semibold text-red-600">Tersimpan</span>
                                </button>
                            @else
                                <button type="submit" class="flex items-center space-x-2 px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition">
                                    <!-- Icon Bookmark Outline (Kosong) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2">
                                        <path d="M5 5c0-1.1.9-2 2-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                    </svg>
                                    <span class="font-semibold text-gray-700">Simpan</span>
                                </button>
                            @endif
                        </form>
                    @endif
                @else
                    <!-- Like Button (Guest) -->
                    <a href="{{ route('login') }}" class="inline-flex items-center space-x-2 px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <!-- Icon Heart Outline (Kosong) -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        <span class="font-semibold text-gray-700">Suka</span>
                    </a>
                    
                    <!-- Bookmark Button (Guest) -->
                    <a href="{{ route('login') }}" class="inline-flex items-center space-x-2 px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <!-- Icon Bookmark Outline (Kosong) -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2">
                            <path d="M5 5c0-1.1.9-2 2-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                        <span class="font-semibold text-gray-700">Simpan</span>
                    </a>
                @endauth
            </div>
        </div>

        <!-- Reply Section -->
        <div class="mt-6 rounded-xl bg-white p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-800 mb-4">💬 Balasan ({{ $post->replies->count() }})</h3>

            @auth
            <!-- Reply Form -->
            <form action="{{ route('replies.store', $post->id) }}" method="POST" class="mb-6">
                @csrf
                <div class="flex space-x-3">
                    @if(Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" 
                             alt="{{ Auth::user()->name }}" 
                             class="h-10 w-10 rounded-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3B82F6&color=fff&size=40" 
                             alt="{{ Auth::user()->name }}" 
                             class="h-10 w-10 rounded-full">
                    @endif
                    <div class="flex-1">
                        <textarea name="content" 
                                  rows="3" 
                                  placeholder="Tulis balasan Anda..." 
                                  class="w-full rounded-lg border border-gray-300 p-3 text-sm focus:border-teal-500 focus:ring-teal-500" 
                                  required></textarea>
                        <div class="mt-2 flex justify-end">
                            <button type="submit" class="bg-teal-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-teal-700 transition">
                                Kirim Balasan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            @else
            <div class="mb-6 p-4 bg-gray-50 rounded-lg text-center">
                <p class="text-gray-600">
                    <a href="{{ route('login') }}" class="text-teal-600 hover:underline font-semibold">Login</a> 
                    untuk memberikan balasan
                </p>
            </div>
            @endauth

            <!-- Replies List -->
            <div class="space-y-4">
                @forelse($post->replies as $reply)
                <div class="flex space-x-3 p-4 bg-gray-50 rounded-lg">
                    @if($reply->user->profile_picture)
                        <img src="{{ asset('storage/' . $reply->user->profile_picture) }}" 
                             alt="{{ $reply->user->name }}" 
                             class="h-10 w-10 rounded-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->name) }}&background=3B82F6&color=fff&size=40" 
                             alt="{{ $reply->user->name }}" 
                             class="h-10 w-10 rounded-full">
                    @endif
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $reply->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                            </div>
                            @auth
                            @if($reply->user_id === Auth::id())
                            <form action="{{ route('replies.destroy', $reply->id) }}" 
                                  method="POST" 
                                  class="inline" 
                                  onsubmit="return confirm('Hapus balasan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold">
                                    Hapus
                                </button>
                            </form>
                            @endif
                            @endauth
                        </div>
                        <p class="mt-2 text-gray-700">{{ $reply->content }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <p>Belum ada balasan. Jadilah yang pertama!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
