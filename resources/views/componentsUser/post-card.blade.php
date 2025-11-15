<div class="rounded-xl bg-white p-5 shadow-lg relative">
    <div class="flex justify-between items-start">
        
        <a href="{{ url('/profile/' . $post['user_slug']) }}" class="flex items-center space-x-3 hover:opacity-80 transition">
            <div class="h-10 w-10 rounded-full bg-{{ $post['img_color'] }} flex-shrink-0"></div>
            <div>
                <p class="font-semibold text-gray-900">{{ $post['name'] }}</p>
                <p class="text-xs text-gray-500">{{ $post['time'] }}</p>
            </div>
        </a>
        
        {{-- Dropdown Laporkan Postingan --}}
        <div class="relative">
            <button 
                class="report-toggle-btn text-gray-400 hover:text-gray-700 p-1 rounded-full transition" 
                data-target="menu-{{ $post['id'] }}"
                data-post-id="{{ $post['id'] }}"
            >
                ⋮
            </button>
            
            <div 
                id="menu-{{ $post['id'] }}" 
                class="report-menu-content absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-10"
            >
                <a href="#report-{{ $post['id'] }}" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50" role="menuitem">
                    ⚠️ Laporkan Postingan
                </a>
            </div>
        </div>
        
    </div>

    <p class="mt-3 text-gray-700">{{ $post['content'] }}</p>
    <img
        src="https://via.placeholder.com/600x350/{{ $post['img_src'] }}/ffffff?text={{ $post['img_text'] }}"
        alt="Post Image"
        class="mt-3 w-full rounded-lg object-cover"
    />
    <div class="mt-4 flex justify-between border-t border-gray-100 pt-3 text-sm text-gray-500">
        <div class="flex space-x-4">
            <span class="cursor-pointer hover:text-red-500">❤ {{ $post['likes'] }} Suka</span>
            <span class="cursor-pointer hover:text-teal-600">💬 {{ $post['comments'] }} Komentar</span>
        </div>
        <div class="flex space-x-3">
            <span class="cursor-pointer hover:text-teal-600">🔖 Bookmark</span>
            <span class="cursor-pointer hover:text-teal-600">↗ Bagikan</span>
        </div>
    </div>
</div>