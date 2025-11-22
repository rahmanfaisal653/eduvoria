<div id="review-report-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center">
    
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-4 transform transition-all duration-300 flex flex-col max-h-[90vh]">
        
        {{-- HEADER --}}
        <div class="p-6 border-b bg-gray-50 rounded-t-xl flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-gray-800">
                    Tinjauan Laporan #<span id="review-id">000</span>
                </h3>
                <span id="review-priority" class="text-xs font-semibold px-2 py-1 rounded-full bg-gray-200 text-gray-700 mt-1 inline-block">
                    Priority
                </span>
            </div>
            <button onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        {{-- BODY (Scrollable) --}}
        <div class="p-6 overflow-y-auto flex-1 space-y-6">
            
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-xs text-blue-600 font-bold uppercase">Pelapor</p>
                    <p id="review-reporter" class="text-sm font-semibold text-gray-800 mt-1">-</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <p class="text-xs text-purple-600 font-bold uppercase">Jenis Pelanggaran</p>
                    <p id="review-type" class="text-sm font-semibold text-gray-800 mt-1">-</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Alasan / Deskripsi Laporan:</label>
                <div class="bg-gray-100 p-4 rounded-lg border border-gray-200">
                    <p id="review-desc" class="text-sm text-gray-600 italic">...</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Konten yang Dilaporkan (Ringkasan):</label>
                <div class="bg-white border-2 border-dashed border-gray-300 p-4 rounded-lg">
                    <p id="review-summary" class="text-sm text-gray-800 whitespace-pre-wrap">...</p>
                </div>
            </div>

        </div>

        {{-- FOOTER (Actions) --}}
        <div class="p-6 border-t bg-gray-50 rounded-b-xl flex justify-end space-x-3">
            
            {{-- Tombol Batalkan Laporan (Hapus Laporannya saja) --}}
            <form id="form-reject-report" method="POST" action="#">
                @csrf
                <button type="submit" onclick="return confirm('Abaikan laporan ini? Data laporan akan dihapus, tapi konten tetap aman.')"
                    class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 font-medium transition">
                    Abaikan / Tolak Laporan
                </button>
            </form>

            {{-- Tombol Hapus Konten (Hapus Postingan & Laporan) --}}
            <form id="form-delete-content" method="POST" action="#">
                @csrf
                <input type="hidden" name="action" value="banned">
                <button type="submit" onclick="return confirm('Yakin hapus konten ini? Tindakan ini tidak bisa dibatalkan.')"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition shadow-md">
                    Hapus Konten (Valid)
                </button>
            </form>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // ========================================================
        // 1. SETUP VARIABEL (ID TUNGGAL: review-report-modal)
        // ========================================================
        const reviewModal = document.getElementById('review-report-modal'); 
        const reviewButtons = document.querySelectorAll('.review-report-btn');
        
        // Elemen Teks
        const textId = document.getElementById('review-id');
        const textPriority = document.getElementById('review-priority');
        const textReporter = document.getElementById('review-reporter');
        const textType = document.getElementById('review-type');
        const textDesc = document.getElementById('review-desc');
        const textSummary = document.getElementById('review-summary');
        
        // Form Actions
        const formReject = document.getElementById('form-reject-report');
        const formDeleteContent = document.getElementById('form-delete-content');

        // ========================================================
        // 2. LOGIKA BUKA MODAL
        // ========================================================
        if (reviewModal) {
            reviewButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Ambil Data dari Atribut Tombol
                    const id = this.getAttribute('data-id');
                    const type = this.getAttribute('data-type');
                    const reporter = this.getAttribute('data-reporter');
                    const priority = this.getAttribute('data-priority');
                    const desc = this.getAttribute('data-desc');
                    const summary = this.getAttribute('data-summary');

                    // Isi Data ke Modal
                    if(textId) textId.textContent = id;
                    if(textReporter) textReporter.textContent = reporter;
                    if(textType) textType.textContent = type;
                    if(textDesc) textDesc.textContent = desc;
                    if(textSummary) textSummary.textContent = summary;

                    // Atur Badge Priority
                    if(textPriority) {
                        textPriority.textContent = priority;
                        textPriority.className = "text-xs font-semibold px-2 py-1 rounded-full mt-1 inline-block ";
                        
                        if(priority === 'High') textPriority.classList.add('bg-red-100', 'text-red-800');
                        else if(priority === 'Medium') textPriority.classList.add('bg-yellow-100', 'text-yellow-800');
                        else textPriority.classList.add('bg-gray-200', 'text-gray-700');
                    }

                    // Atur URL Action Form
                    if(formReject) formReject.action = `/admin/reports/delete/${id}`;
                    if(formDeleteContent) formDeleteContent.action = `/admin/reports/resolve/${id}`;

                    // Tampilkan Modal
                    reviewModal.classList.remove('hidden');
                });
            });

            // Tutup jika klik background
            reviewModal.addEventListener('click', function(e) {
                if (e.target === reviewModal) {
                    reviewModal.classList.add('hidden');
                }
            });
        } else {
            console.error("Error: ID 'review-report-modal' tidak ditemukan di HTML!");
        }
    });

    // ========================================================
    // 3. FUNGSI TUTUP MODAL (Global)
    // ========================================================
    function closeReviewModal() {
        const m = document.getElementById('review-report-modal'); // Tunggal
        if(m) m.classList.add('hidden');
    }
</script>