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
            <button 
                class="report-toggle-btn text-gray-400 hover:text-gray-700 p-1 rounded-full transition" 
                data-target="menu-{{ $post->id }}"
                data-post-id="{{ $post->id }}"
            >
                ⋮
            </button>
            
            <div 
                id="menu-{{ $post->id }}" 
                class="report-menu-content absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-10"
            >
                <a href="#report-{{ $post->id }}" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50" role="menuitem">
                    ⚠️ Laporkan Postingan
                </a>
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
            @auth
            <form action="{{ route('bookmark.toggle', $post->id) }}" method="POST" class="inline bookmark-form">
                @csrf
                <button type="submit" class="cursor-pointer hover:text-teal-600">
                    🔖 Bookmark
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="cursor-pointer hover:text-teal-600">🔖 Bookmark</a>
            @endauth
        </div>
    </div>
</div>