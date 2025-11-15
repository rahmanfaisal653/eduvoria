    <div id="review-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-xl mx-4 transform transition-all duration-300">
            <h3 id="modal-header-title" class="text-xl font-bold text-orange-500 border-b pb-2 mb-4">Tinjauan Pelanggaran Postingan <span id="review-post-id">#XXXX</span></h3>
            
            <div id="review-details" class="space-y-3 mb-6 max-h-80 overflow-y-auto">
                <p class="text-sm font-semibold text-gray-800">Detail Postingan:</p>
                <p id="review-post-summary" class="text-gray-700 p-3 bg-gray-50 rounded-lg italic">Ringkasan isi konten...</p>
                
                <p class="text-sm font-semibold text-gray-800 pt-2">Laporan Diterima:</p>
                <ul id="review-report-list" class="list-disc list-inside text-sm text-gray-700 ml-4 space-y-1">
                    <li class="text-red-600">Pelanggaran: Ujaran Kebencian (5 Laporan)</li>
                    <li>Pelanggaran: Konten Tidak Pantas (2 Laporan)</li>
                </ul>

                <div class="pt-3">
                    <label for="admin-review-notes" class="block text-sm font-semibold text-gray-800">Catatan Admin:</label>
                    <textarea 
                        id="admin-review-notes" 
                        rows="2" 
                        placeholder="Masukkan alasan Anda menghapus atau menyetujui konten ini..." 
                        class="mt-1 w-full rounded-lg border border-gray-300 p-3 text-sm focus:border-teal-500 focus:ring-teal-500"
                    ></textarea>
                </div>
            </div>

            <div class="flex justify-between space-x-4 pt-3 border-t">
                <button type="button" id="close-review-modal" class="py-2 px-4 rounded-lg text-gray-600 border border-gray-300 hover:bg-gray-100 transition">
                    Tutup Review
                </button>
                <div class="flex space-x-3">
                    <button type="button" id="action-delete" class="py-2 px-4 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                        Hapus Konten
                    </button>
                    <button type="button" id="action-approve" class="py-2 px-4 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 transition">
                        Tidak Melanggar (Setujui)
                    </button>
                </div>
            </div>
        </div>
    </div>