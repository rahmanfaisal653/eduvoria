<div id="detail-report-modal"
     class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center">

    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg mx-4 overflow-y-auto max-h-[90vh]">
        <h3 class="text-xl font-bold text-cyan-600 mb-4">
            Detail Laporan
        </h3>

        <div class="space-y-3 text-sm">
            <p><strong>ID Report:</strong> <span id="detail-report-id"></span></p>
            <p><strong>Tipe:</strong> <span id="detail-report-type"></span></p>
            <p><strong>Prioritas:</strong> <span id="detail-report-priority"></span></p>
            <p><strong>Dilaporkan Oleh:</strong> <span id="detail-report-reported-by"></span></p>

            <div>
                <p class="font-semibold mb-1">Deskripsi</p>
                <p id="detail-report-description"
                   class="text-gray-700 whitespace-pre-line"></p>
            </div>

            <!-- Foto -->
            <div id="detail-report-image-wrapper" class="mt-3 hidden">
                <p class="font-semibold mb-1">Foto</p>
                <img id="detail-report-image"
                     src=""
                     alt="Foto Laporan"
                     class="w-full rounded-lg object-cover max-h-72">
            </div>
        </div>

        <div class="mt-5 text-right">
            <button id="close-detail-report"
                class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
/**
 * DETAIL REPORT MODAL
 * Aman dipakai di halaman list report
 */
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('detail-report-modal');
    const closeBtn = document.getElementById('close-detail-report');

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.detail-report-btn');
        if (!btn) return;

        e.preventDefault();

        document.getElementById('detail-report-id').textContent =
            btn.dataset.id || '-';

        document.getElementById('detail-report-type').textContent =
            btn.dataset.type || '-';

        document.getElementById('detail-report-priority').textContent =
            btn.dataset.priority || '-';

        document.getElementById('detail-report-reported-by').textContent =
            btn.dataset.reportedBy || '-';

        document.getElementById('detail-report-description').textContent =
            btn.dataset.description || '-';

        // Foto handling
        const imageWrapper = document.getElementById('detail-report-image-wrapper');
        const imageEl = document.getElementById('detail-report-image');

        if (btn.dataset.foto) {
            imageEl.src = btn.dataset.foto;
            imageWrapper.classList.remove('hidden');
        } else {
            imageEl.src = '';
            imageWrapper.classList.add('hidden');
        }

        modal.classList.remove('hidden');
    });

    closeBtn.addEventListener('click', function () {
        modal.classList.add('hidden');
    });

    modal.addEventListener('click', function (e) {
        if (e.target === modal) modal.classList.add('hidden');
    });
});
</script>
