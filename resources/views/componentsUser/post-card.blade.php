<div class="rounded-xl bg-white p-5 shadow-lg relative">
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
        
        {{-- Dropdown Laporkan Postingan --}}
        <div class="relative">
            {{-- TOMBOL TITIK TIGA --}}
            {{-- Kita panggil fungsi JS langsung di sini --}}
            <button type="button"
                    onclick="toggleMenu('menu-{{ $post->id }}')"
                    class="text-gray-400 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100 transition focus:outline-none">
                ⋮
            </button>
            
            {{-- MENU DROPDOWN --}}
            {{-- Tambahkan z-50 agar muncul di atas elemen lain --}}
            <div id="menu-{{ $post->id }}" 
                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50"
                style="display: none;"> {{-- Double protection hidden --}}
                
                <div class="py-1">
                    <a href="#" 
                    onclick="event.preventDefault(); openUserReportModal('{{ $post->id }}', '{{ Str::limit($post->content, 30) }}'); toggleMenu('menu-{{ $post->id }}');"
                    class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left">
                        ⚠️ Laporkan
                    </a>
                </div>
            </div>
        </div>
        
    </div>

    <a href="{{ route('posts.show', $post->id) }}" class="block">
        <p class="mt-3 text-gray-700 hover:text-gray-900 cursor-pointer">{{ $post->content }}</p>
        
        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" 
                 alt="Post Image" 
                 class="mt-3 w-full rounded-lg object-cover max-h-96 hover:opacity-90 transition"/>
        @endif
    </a>

    <div class="mt-4 flex justify-between border-t border-gray-100 pt-3 text-sm text-gray-500">
        <div class="flex space-x-4 items-center">
            <span class="flex items-center space-x-1">
                <span>❤</span>
                <span>{{ $post->likes_count }} Suka</span>
            </span>
            <span class="cursor-pointer hover:text-blue-500 flex items-center space-x-1" onclick="toggleReplyForm('reply-form-{{ $post->id }}')">
                <span>💬</span>
                <span>{{ $post->replies->count() }} Balasan</span>
            </span>
            <span class="flex items-center space-x-1">
                <span>👁</span>
                <span>{{ $post->views ?? 0 }} Views</span>
            </span>
            <span class="flex items-center space-x-1">
                <span>🔖</span>
                <span>{{ $post->bookmarks_count ?? 0 }} Bookmark</span>
            </span>
        </div>
        <div class="flex space-x-3 items-center">
            @auth
                <!-- Cek apakah sudah di-like -->
                <?php 
                    $sudahLike = \App\Models\Like::where('user_id', Auth::id())
                                                 ->where('post_id', $post->id)
                                                 ->exists();
                ?>
                
                <!-- Tombol Toggle Like dengan icon SVG -->
                <form action="{{ route('like.toggle', $post->id) }}" method="POST">
                    @csrf
                    @if($sudahLike)
                        <button type="submit" class="hover:scale-110 transition transform" title="Unlike">
                            <!-- Icon Heart Filled (Merah) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="#EF4444">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </button>
                    @else
                        <button type="submit" class="hover:scale-110 transition transform" title="Like">
                            <!-- Icon Heart Outline (Kosong) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </button>
                    @endif
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:scale-110 transition transform" title="Login untuk Like">
                    <!-- Icon Heart Outline (Kosong) -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </a>
            @endauth

            @auth
                @if($post->user_id != Auth::id())
                    <!-- Cek apakah sudah di-bookmark -->
                    <?php 
                        $sudahBookmark = \App\Models\Bookmark::where('user_id', Auth::id())
                                                            ->where('post_id', $post->id)
                                                            ->exists();
                    ?>
                    
                    <!-- Tombol Toggle Bookmark dengan icon SVG -->
                    <form action="{{ route('bookmark.toggle', $post->id) }}" method="POST">
                        @csrf
                        @if($sudahBookmark)
                            <button type="submit" class="hover:scale-110 transition transform" title="Hapus dari Bookmark">
                                <!-- Icon Bookmark Filled (Merah) -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="#53decdff">
                                    <path d="M5 5c0-1.1.9-2 2-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                            </button>
                        @else
                            <button type="submit" class="hover:scale-110 transition transform" title="Tambah ke Bookmark">
                                <!-- Icon Bookmark Outline (Kosong) -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2">
                                    <path d="M5 5c0-1.1.9-2 2-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                            </button>
                        @endif
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="hover:scale-110 transition transform" title="Login untuk Bookmark">
                    <!-- Icon Bookmark Outline (Kosong) -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2">
                        <path d="M5 5c0-1.1.9-2 2-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                </a>
            @endauth
        </div>
    </div>


    <div id="reply-form-{{ $post->id }}" class="mt-4 hidden">
        @auth
        <form action="{{ route('replies.store', $post->id) }}" method="POST" class="mb-4">
            @csrf
            <div class="flex space-x-2">
                <textarea name="content" rows="2" placeholder="Tulis balasan..." 
                    class="flex-1 rounded-lg border border-gray-300 p-2 text-sm focus:border-teal-500 focus:ring-teal-500" required></textarea>
                <button type="submit" class="bg-teal-600 text-white px-4 rounded-lg text-sm hover:bg-teal-700">Kirim</button>
            </div>
        </form>
        @else
        <p class="text-gray-500 text-sm">
            <a href="{{ route('login') }}" class="text-teal-600 hover:underline">Login</a> untuk membalas
        </p>
        @endauth


        <div class="space-y-3">
            @foreach($post->replies as $reply)
            <div class="flex space-x-3 bg-gray-50 p-3 rounded-lg">
                @if($reply->user->profile_picture)
                    <img src="{{ asset('storage/' . $reply->user->profile_picture) }}" 
                         alt="{{ $reply->user->name }}" 
                         class="h-8 w-8 rounded-full object-cover">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->name) }}&background=3B82F6&color=fff&size=32" 
                         alt="{{ $reply->user->name }}" 
                         class="h-8 w-8 rounded-full">
                @endif
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold text-sm text-gray-900">{{ $reply->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                        </div>
                        @auth
                        @if($reply->user_id === Auth::id())
                        <form action="{{ route('replies.destroy', $reply->id) }}" method="POST" class="inline" 
                              onsubmit="return confirm('Hapus balasan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Hapus</button>
                        </form>
                        @endif
                        @endauth
                    </div>
                    <p class="mt-1 text-sm text-gray-700">{{ $reply->content }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Fungsi untuk Buka/Tutup Menu
    function toggleMenu(menuId) {
        // 1. Ambil elemen menu berdasarkan ID
        var menu = document.getElementById(menuId);
        
        // 2. Cek apakah sedang sembunyi atau tidak
        if (menu.style.display === "none" || menu.classList.contains('hidden')) {
            // TAMPILKAN
            // Tutup menu lain dulu biar gak numpuk
            closeAllMenus(); 
            menu.style.display = "block";
            menu.classList.remove('hidden');
        } else {
            // SEMBUNYIKAN
            menu.style.display = "none";
            menu.classList.add('hidden');
        }
    }

    // Fungsi bantu untuk menutup semua menu yang terbuka
    function closeAllMenus() {
        var dropdowns = document.querySelectorAll('[id^="menu-"]'); // Cari semua ID yang diawali "menu-"
        dropdowns.forEach(function(d) {
            d.style.display = "none";
            d.classList.add('hidden');
        });
    }

    // Tutup menu kalau klik di sembarang tempat
    window.onclick = function(event) {
        // Jika yang diklik BUKAN tombol titik tiga
        if (!event.target.matches('.text-gray-400') && !event.target.matches('button')) {
            closeAllMenus();
        }
    }

    // Fungsi untuk toggle form reply
    function toggleReplyForm(formId) {
        var form = document.getElementById(formId);
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
        } else {
            form.classList.add('hidden');
        }
    }
</script>
@endpush

