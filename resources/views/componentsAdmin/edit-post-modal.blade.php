<div id="edit-post-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center">
    
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg mx-4 transform transition-all duration-300">
        
        {{-- Header --}}
        <div class="text-center mb-5">
            <h3 class="text-2xl font-bold text-teal-600 border-b pb-2">
                Edit Postingan
            </h3>
            <p class="text-xs text-gray-500 mt-1">Perbarui konten dan status postingan.</p>
        </div>
        
        {{-- FORM UPDATE --}}
        <form id="edit-post-form" method="POST" action="#" enctype="multipart/form-data">
            @csrf
            {{-- Tambahkan method PUT/PATCH jika route Anda menggunakannya, tapi kita ikuti kode Controller Anda yang menggunakan POST --}}
            
            <div class="space-y-4 mb-4 max-h-96 overflow-y-auto px-1">
                
                {{-- 1. INPUT KONTEN --}}
                <div>
                    <label for="edit-content" class="block text-sm font-semibold text-gray-800 mb-1">Konten Postingan</label>
                    <textarea name="content" id="edit-content" rows="5" required
                        class="w-full rounded-lg border border-gray-300 p-3 text-sm focus:border-teal-500 focus:ring-teal-500 placeholder-gray-400"
                        placeholder="Tulis isi konten di sini..."></textarea>
                </div>
                
                {{-- 2. INPUT PENULIS (READ-ONLY, hanya untuk tampilan) --}}
                <div>
                    <label for="edit-user-name" class="block text-sm font-semibold text-gray-800 mb-1">Nama Penulis</label>
                    {{-- Input 'author' diganti 'user-name' dan dibuat read-only --}}
                    <input type="text" id="edit-user-name" readonly
                        class="w-full rounded-lg border border-gray-300 p-2 text-sm bg-gray-100 text-gray-600"
                        placeholder="Nama Penulis">
                    
                    {{-- Input Hidden untuk user_id (optional, jika diperlukan di backend) --}}
                    <input type="hidden" name="user_id" id="edit-user-id">
                </div>
                
                {{-- 3. INPUT GAMBAR BARU (Opsional) --}}
                <div>
                    <label for="edit-image" class="block text-sm font-semibold text-gray-800 mb-1">Ganti Gambar (Opsional)</label>
                    <input type="file" name="image" id="edit-image" accept="image/*"
                        class="w-full rounded-lg border border-gray-300 p-2 text-sm focus:border-teal-500 focus:ring-teal-500">
                    {{-- Field 'image' harus disiapkan karena ada di Controller Update Anda --}}
                </div>

                {{-- 4. INPUT STATUS --}}
                <div>
                    <label for="edit-status" class="block text-sm font-semibold text-gray-800 mb-1">Status</label>
                    <select name="status" id="edit-status" required
                        class="w-full rounded-lg border border-gray-300 p-2 text-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="active">Active (Tayang)</option>
                        <option value="inactive">Inactive (Disembunyikan)</option>
                        <option value="archived">Archived (Diarsipkan)</option>
                        <option value="reported">Reported (Dilaporkan)</option>
                    </select>
                </div>

            </div>

            {{-- FOOTER / TOMBOL (Tidak diubah) --}}
            <div class="flex justify-end space-x-3 pt-3 border-t mt-4">
                <button type="button" id="cancel-edit-post" 
                    onclick="document.getElementById('edit-post-modal').classList.add('hidden')" 
                    class="py-2 px-4 rounded-lg border border-gray-300 text-gray-600 font-semibold hover:bg-gray-100 transition">
                    Batal
                </button>
                <button type="submit" 
                    class="py-2 px-4 rounded-lg bg-teal-600 text-white font-semibold hover:bg-teal-700 transition shadow-md">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Definisikan Elemen
        const editButtons = document.querySelectorAll('.edit-post-btn');
        const editModal = document.getElementById('edit-post-modal');
        const editForm = document.getElementById('edit-post-form');
        
        // Elemen Input di dalam Modal (DISESUAIKAN)
        const inputContent = document.getElementById('edit-content');
        const inputUserName = document.getElementById('edit-user-name'); // Ganti dari inputAuthor
        const inputUserId = document.getElementById('edit-user-id');     // Input Hidden
        const inputStatus = document.getElementById('edit-status');

        // 2. Loop setiap tombol Edit
        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); 

                // A. AMBIL DATA DARI TOMBOL (DISESUAIKAN DENGAN NAMA DATA BARU)
                const id = this.getAttribute('data-id');
                const content = this.getAttribute('data-content');
                const userName = this.getAttribute('data-user-name'); // Nama Penulis
                const userId = this.getAttribute('data-user-id');     // ID Penulis
                const status = this.getAttribute('data-status');

                // B. ISI FORM MODAL DENGAN DATA TERSEBUT
                if(inputContent) inputContent.value = content;
                if(inputUserName) inputUserName.value = userName; // Mengisi Nama
                if(inputUserId) inputUserId.value = userId;       // Mengisi ID Hidden
                if(inputStatus) inputStatus.value = status;

                // C. UBAH URL ACTION FORM
                // Format: /admin/content/update/{id}
                if(editForm) {
                    editForm.action = `/admin/content/update/${id}`;
                }

                // D. TAMPILKAN MODAL
                if(editModal) {
                    editModal.classList.remove('hidden');
                }
            });
        });

        // 3. LOGIKA TUTUP MODAL (sudah ada)
        const cancelBtn = document.getElementById('cancel-edit-post');
        if(cancelBtn) {
            cancelBtn.addEventListener('click', function() {
                editModal.classList.add('hidden');
            });
        }
    });
</script>