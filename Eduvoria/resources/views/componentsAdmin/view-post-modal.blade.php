@props(['id' => 'view-modal', 'title' => 'Detail Postingan', 'maxWidth' => '500px'])

<div id="{{ $id }}"
    {{ $attributes->merge(['class' => 'fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center']) }}
>
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg mx-4 transform transition-all duration-300">
        <h3 class="text-xl font-bold text-teal-600 border-b pb-2 mb-4">
            {{ $title }} <span id="view-post-id">#XXXX</span>
        </h3>
        
        <div id="view-post-content" class="space-y-3 mb-4 max-h-96 overflow-y-auto">
            <p class="text-sm font-semibold text-gray-800">Judul/Teks Konten:</p>
            <p id="view-post-text" class="text-gray-700 p-3 bg-gray-50 rounded-lg italic">Konten Teks Penuh Ada Di Sini...</p>
            
            <p class="text-sm font-semibold text-gray-800 pt-2">Informasi:</p>
            <div class="flex justify-between text-sm text-gray-600">
                <span>Penulis: <strong id="view-post-author"></strong></span>
                <span>Status: <strong id="view-post-status"></strong></span>
            </div>
            
            <div id="view-post-media" class="h-40 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500 text-xs mt-3">
                [Area Tampilan Gambar/Media]
            </div>
        </div>

        <div class="flex justify-end pt-3">
            <button type="button" id="close-view-modal" onclick="document.getElementById('{{ $id }}').classList.add('hidden')" class="py-2 px-4 rounded-lg bg-gray-300 text-gray-800 font-semibold hover:bg-gray-400 transition">
                Tutup
            </button>
        </div>
    </div>
</div>
