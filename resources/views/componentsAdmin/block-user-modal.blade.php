<div id="block-user-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-sm mx-4 text-center">
        <h3 class="text-xl font-bold text-red-600 mb-2">Konfirmasi Pemblockiran</h3>
        <p class="text-gray-700 mb-6">Anda yakin ingin memblokir <strong id="blokir-post-id">#XXXX</strong> akun ini? Aksi ini tidak dapat dibatalkan.</p>

        <div class="flex justify-center space-x-4">
            <button 
                type="button" 
                id="block-delete-modal" 
                onclick="document.getElementById('block-user-modal').classList.add('hidden')" 
                class="py-2 px-4 rounded-lg text-gray-600 border border-gray-300 hover:bg-gray-100 transition"
            >
                Batal
            </button>
            <button type="button" id="confirm-block-button" data-id="" class="py-2 px-4 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                Ya, Blokir
            </button>
        </div>
    </div>
</div>