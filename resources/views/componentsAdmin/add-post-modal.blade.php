<div id="add-post-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center">
    
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg mx-4 transform transition-all duration-300">
        
        {{-- Header --}}
        <div class="text-center mb-5">
            <h3 class="text-2xl font-bold text-teal-600 border-b pb-2">
                Buat Postingan Baru 📝
            </h3>
            <p class="text-xs text-gray-500 mt-1">Isi konten di bawah ini untuk menambahkan artikel baru.</p>
        </div>
        
        {{-- FORM TAMBAH --}}
        {{-- Action mengarah ke route store yang sudah kita buat --}}
        <form id="add-post-form" method="POST" action="{{ route('admin.content.store') }}">
            @csrf

            <div class="space-y-4 mb-4 max-h-96 overflow-y-auto px-1">
                
                {{-- 1. INPUT KONTEN --}}
                <div>
                    <label for="add-content" class="block text-sm font-semibold text-gray-800 mb-1">Konten Postingan</label>
                    <textarea name="content" id="add-content" rows="5" required
                        class="w-full rounded-lg border border-gray-300 p-3 text-sm focus:border-teal-500 focus:ring-teal-500 placeholder-gray-400"
                        placeholder="Tulis apa yang sedang terjadi..."></textarea>
                </div>
                
                {{-- 2. INPUT PENULIS --}}
                <div>
                    <label for="add-author" class="block text-sm font-semibold text-gray-800 mb-1">Nama Penulis</label>
                    <input type="text" name="author" id="add-author" required
                        class="w-full rounded-lg border border-gray-300 p-2 text-sm focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Misal: Admin Sekolah">
                </div>

                {{-- 3. INPUT STATUS --}}
                <div>
                    <label for="add-status" class="block text-sm font-semibold text-gray-800 mb-1">Status Awal</label>
                    <select name="status" id="add-status" required
                        class="w-full rounded-lg border border-gray-300 p-2 text-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="active">Active (Tayang)</option>
                        <option value="inactive">Inactive (Disembunyikan)</option>
                        <option value="archived">Archived (Diarsipkan)</option>
                        <option value="reported">Reported (Dilaporkan)</option>
                    </select>
                </div>

            </div>

            {{-- FOOTER / TOMBOL --}}
            <div class="flex justify-end space-x-3 pt-3 border-t mt-4">
                {{-- Tombol Batal --}}
                <button type="button" id="cancel-add-post" 
                    onclick="document.getElementById('add-post-modal').classList.add('hidden'); document.getElementById('add-post-form').reset();" 
                    class="py-2 px-4 rounded-lg border border-gray-300 text-gray-600 font-semibold hover:bg-gray-100 transition">
                    Batal
                </button>
                
                {{-- Tombol Simpan --}}
                <button type="submit" 
                    class="py-2 px-4 rounded-lg bg-teal-600 text-white font-semibold hover:bg-teal-700 transition shadow-md">
                    Posting Sekarang
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    // --- LOGIKA MODAL TAMBAH POSTINGAN ---
    const addPostBtn = document.getElementById('add-post-btn');
    const addPostModal = document.getElementById('add-post-modal');
    const addPostForm = document.getElementById('add-post-form');

    // Buka Modal
    if(addPostBtn && addPostModal) {
        addPostBtn.addEventListener('click', function() {
            addPostModal.classList.remove('hidden');
        });
    }

    // Tutup Modal (Opsional, sudah ada inline onclick di tombol Batal, tapi ini untuk klik backdrop)
    if(addPostModal) {
        addPostModal.addEventListener('click', function(e) {
            if(e.target === addPostModal) {
                addPostModal.classList.add('hidden');
                if(addPostForm) addPostForm.reset(); // Bersihkan form saat ditutup
            }
        });
    }
</script>