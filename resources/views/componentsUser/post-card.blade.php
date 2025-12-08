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
        <div class="flex space-x-4">
            <span class="cursor-pointer hover:text-red-500">❤ {{ $post->likes_count }} Suka</span>
            <span class="cursor-pointer hover:text-blue-500" onclick="toggleReplyForm('reply-form-{{ $post->id }}')">
                💬 {{ $post->replies->count() }} Balasan
            </span>
            <span class="hover:text-teal-500">👁 {{ $post->views ?? 0 }} Views</span>
        </div>
        <div class="flex space-x-3">
            @auth
                <!-- Cek apakah sudah di-bookmark -->
                <?php 
                    $sudahBookmark = \App\Models\Bookmark::where('user_id', Auth::id())
                                                        ->where('post_id', $post->id)
                                                        ->exists();
                ?>
                
                <!-- Tombol Toggle Bookmark -->
                <form action="{{ route('bookmark.toggle', $post->id) }}" method="POST">
                    @csrf
                    @if($sudahBookmark)
                        <button type="submit" class="cursor-pointer hover:text-red-600">
                            ❌ Hapus Bookmark
                        </button>
                    @else
                        <button type="submit" class="cursor-pointer hover:text-teal-600">
                            🔖 Bookmark
                        </button>
                    @endif
                </form>
            @else
                <a href="{{ route('login') }}" class="cursor-pointer hover:text-teal-600">🔖 Bookmark</a>
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

