<div id="edit-report-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center transition-opacity">
    {{-- Ubah max-w-md menjadi max-w-lg agar sedikit lebih lebar seperti di gambar --}}
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4 transform transition-all scale-100">

        {{-- Header Modal --}}
        <div class="text-center mb-8">
            {{-- Judul Utama: Ubah warna jadi teal, lebih tebal, dan hapus border bawah --}}
            <h3 class="text-3xl font-extrabold text-teal-700 mb-3">Edit Data Laporan</h3>
            {{-- Deskripsi: Tambahkan teks deskripsi seperti di gambar --}}
            <p class="text-gray-500 text-sm">Perbarui detail laporan, pelapor, atau status prioritas.</p>
        </div>

        {{-- Form Update --}}
        {{-- Action diisi via JS saat modal dibuka --}}
        <form id="edit-report-form" method="POST" action="#" enctype="multipart/form-data">
            @csrf
            <div class="space-y-5">
                
                {{-- WAJIB: Field ID Tersembunyi (Untuk mengidentifikasi record yang diupdate) --}}
                <input type="hidden" name="id" id="edit-report-id-hidden">

                {{-- 1. Edit Jenis Pelanggaran --}}
                <div>
                    <label for="edit-report-type" class="block text-sm font-bold text-gray-800 mb-2">Tipe Pelanggaran</label>
                    <select name="type" id="edit-report-type" class="w-full rounded-lg border-gray-300 p-3 text-sm focus:ring-teal-500 focus:border-teal-500 shadow-sm transition">
                        <option value="Spam">Spam</option>
                        <option value="Hate Speech">Hate Speech (Ujaran Kebencian)</option>
                        <option value="False News">False News (Hoax)</option>
                        <option value="Harassment">Harassment (Pelecehan)</option>
                        <option value="Other">Other (Lainnya)</option>
                    </select>
                </div>
                
                {{-- 2. Edit Prioritas --}}
                <div>
                    <label for="edit-report-priority" class="block text-sm font-bold text-gray-800 mb-2">Prioritas</label>
                    <select name="priority" id="edit-report-priority" class="w-full rounded-lg border-gray-300 p-3 text-sm focus:ring-teal-500 focus:border-teal-500 shadow-sm transition">
                        <option value="Low">Low (Rendah)</option>
                        <option value="Medium">Medium (Sedang)</option>
                        <option value="High">High (Tinggi)</option>
                    </select>
                </div>
                
                {{-- 3. Edit Foto (BARU) --}}
                <div>
                    <label for="edit-report-foto" class="block text-sm font-bold text-gray-800 mb-2">Ganti Foto Lampiran</label>
                    <input type="file" name="foto" id="edit-report-foto" accept="image/*" 
                           class="w-full rounded-lg border border-gray-300 p-3 text-sm focus:ring-teal-500 focus:border-teal-500 shadow-sm transition file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:file:text-teal-700"/>
                </div>

                {{-- 4. Edit Deskripsi --}}
                <div>
                    <label for="edit-report-desc" class="block text-sm font-bold text-gray-800 mb-2">Catatan / Deskripsi</label>
                    <textarea name="description" id="edit-report-desc" rows="3" class="w-full rounded-lg border-gray-300 p-3 text-sm focus:ring-teal-500 focus:border-teal-500 shadow-sm transition" placeholder="Tambahkan catatan atau deskripsi..."></textarea>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end space-x-4 pt-6 mt-6 border-t border-gray-100">
                <button type="button" onclick="document.getElementById('edit-report-modal').classList.add('hidden')" 
                    class="px-5 py-2.5 bg-white text-gray-600 rounded-lg border border-gray-300 hover:bg-gray-50 hover:text-gray-800 font-medium transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 font-bold shadow-md transition transform hover:-translate-y-0.5">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // --- LOGIKA MODAL EDIT LAPORAN ---
    const editReportModal = document.getElementById('edit-report-modal');
    const editReportForm = document.getElementById('edit-report-form');
    
    const inputType = document.getElementById('edit-report-type');
    const inputPriority = document.getElementById('edit-report-priority');
    const inputDesc = document.getElementById('edit-report-desc');
    
    const editReportButtons = document.querySelectorAll('.edit-report-btn');

    editReportButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            // 1. Ambil Data
            const id = this.getAttribute('data-id');
            const type = this.getAttribute('data-type');
            const priority = this.getAttribute('data-priority');
            const desc = this.getAttribute('data-description');

            // 2. Isi Form Modal
            if(inputType) inputType.value = type;
            if(inputPriority) inputPriority.value = priority;
            if(inputDesc) inputDesc.value = desc;

            // 3. Update Action URL
            // Format: /admin/reports/update/{id}
            if(editReportForm) {
                editReportForm.action = `/admin/reports/content/update/${id}`;
            }

            // 4. Buka Modal
            editReportModal.classList.remove('hidden');
        });
    });
</script>