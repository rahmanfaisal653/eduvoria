<div id="edit-report-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4 transform transition-all duration-300">
        
        <div class="text-center mb-4">
            <h3 class="text-xl font-bold text-blue-600 border-b pb-2">Edit Data Laporan</h3>
        </div>

        {{-- Form Update --}}
        {{-- Action diisi via JS --}}
        <form id="edit-report-form" method="POST" action="#">
            @csrf
            {{-- Menggunakan POST sesuai request sebelumnya --}}

            <div class="space-y-4">
                
                {{-- 1. Edit Jenis Pelanggaran --}}
                <div>
                    <label for="edit-report-type" class="block text-sm font-semibold text-gray-700">Tipe Pelanggaran</label>
                    <select name="type" id="edit-report-type" class="w-full rounded-lg border border-gray-300 p-2 mt-1 text-sm">
                        <option value="Spam">Spam</option>
                        <option value="Hate Speech">Hate Speech (Ujaran Kebencian)</option>
                        <option value="False News">False News (Hoax)</option>
                        <option value="Harassment">Harassment (Pelecehan)</option>
                        <option value="Other">Other (Lainnya)</option>
                    </select>
                </div>

                {{-- 2. Edit Prioritas --}}
                <div>
                    <label for="edit-report-priority" class="block text-sm font-semibold text-gray-700">Prioritas</label>
                    <select name="priority" id="edit-report-priority" class="w-full rounded-lg border border-gray-300 p-2 mt-1 text-sm">
                        <option value="Low">Low (Rendah)</option>
                        <option value="Medium">Medium (Sedang)</option>
                        <option value="High">High (Tinggi)</option>
                    </select>
                </div>

                {{-- BARU: Edit Pelapor --}}
                <div>
                    <label for="edit-report-reporter" class="block text-sm font-semibold text-gray-700">Pelapor (Reported By)</label>
                    <input type="text" name="reported_by" id="edit-report-reporter" class="w-full rounded-lg border border-gray-300 p-2 mt-1 text-sm">
                </div>

                {{-- BARU: Edit Target / Content Summary --}}
                <div>
                    <label for="edit-report-summary" class="block text-sm font-semibold text-gray-700">Target / Ringkasan Konten</label>
                    <textarea name="content_summary" id="edit-report-summary" rows="2" class="w-full rounded-lg border border-gray-300 p-2 mt-1 text-sm"></textarea>
                </div>

                {{-- 3. Edit Deskripsi --}}
                <div>
                    <label for="edit-report-desc" class="block text-sm font-semibold text-gray-700">Catatan / Deskripsi</label>
                    <textarea name="description" id="edit-report-desc" rows="3" class="w-full rounded-lg border border-gray-300 p-2 mt-1 text-sm"></textarea>
                </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end space-x-3 pt-4 mt-2 border-t">
                <button type="button" onclick="document.getElementById('edit-report-modal').classList.add('hidden')" 
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow">
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