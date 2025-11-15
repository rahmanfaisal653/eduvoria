@extends('layouts.appadmin')

@section('title', 'Laporan Pelanggaran Konten')
@section('page_title', 'Tinjauan Laporan Pelanggaran')

@section('content')
    <section class="space-y-6">
        
        <h2 class="text-2xl font-semibold text-gray-800">Daftar Laporan yang Perlu Ditindaklanjuti</h2>

        {{-- Metrik Ringkasan Laporan --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-red-500">
                <p class="text-sm font-medium text-gray-500">Laporan Prioritas Tinggi</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">5</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-orange-500">
                <p class="text-sm font-medium text-gray-500">Perlu Review Cepat</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">12</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-teal-500">
                <p class="text-sm font-medium text-gray-500">Total Laporan Aktif</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">28</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-cyan-500">
                <p class="text-sm font-medium text-gray-500">Kasus Selesai Hari Ini</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">7</p>
            </div>
        </div>

        {{-- Tabel Laporan Pelanggaran --}}
        <div class="bg-white rounded-xl shadow-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-red-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">ID Laporan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Tipe Pelanggaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Target</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Prioritas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    {{-- Loop data $reports dari Controller --}}
                    @forelse ($reports as $report)
                    <tr class="hover:bg-gray-50" data-report-id="{{ $report['id'] }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $report['type'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $report['target'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $report['priority_color'] }}">
                                {{ $report['priority'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button
                                    class="action-btn-trigger text-red-600 hover:text-red-900" 
                                    data-action="Review"
                                >
                                    Review
                                </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada laporan aktif.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- MODAL AKSI PELANGGARAN (Review/Tindak) akan diletakkan di sini --}}
    @include('componentsAdmin.review-reports-modal')

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- ELEMEN MODAL ---
        const reviewModal = document.getElementById('review-modal');
        const reviewPostId = document.getElementById('review-post-id');
        const modalHeaderTitle = document.getElementById('modal-header-title');
        const reviewPostSummary = document.getElementById('review-post-summary');
        const reviewReportList = document.getElementById('review-report-list');
        const adminReviewNotes = document.getElementById('admin-review-notes');

        const closeReviewModalBtn = document.getElementById('close-review-modal');
        const actionDeleteBtn = document.getElementById('action-delete');
        const actionApproveBtn = document.getElementById('action-approve');
        
        // --- FUNGSI UTILITY ---
        function closeModal() { reviewModal.classList.add('hidden'); adminReviewNotes.value = ''; }
        
        // --- HANDLER MODAL UTAMA ---
        function openReviewModal(reportData, action) {
            
            // 1. Atur Header Modal berdasarkan Aksi
            modalHeaderTitle.textContent = action === 'Tindak' ? `TINDAK LANJUT PELANGGARAN ${reportData.id}` : `Tinjauan Pelanggaran Postingan ${reportData.id}`;
            modalHeaderTitle.classList.toggle('text-red-600', action === 'Tindak');
            modalHeaderTitle.classList.toggle('text-orange-500', action === 'Review');

            // 2. Isi Detail Laporan
            reviewPostId.textContent = reportData.id;
            
            // Konten Ringkasan (Menggunakan content_summary dari data-attribute)
            reviewPostSummary.textContent = reportData.summary; 
            
            // 3. Reset dan Isi Daftar Laporan (Simulasi)
            reviewReportList.innerHTML = '';
            const reportListItem = document.createElement('li');
            
            // Menggunakan fallback untuk mencegah "undefined"
            const type = reportData.type || 'N/A';
            const priority = reportData.priority || 'N/A';
            
            reportListItem.textContent = `Pelanggaran: ${type} (${priority} Prioritas)`;
            reportListItem.className = 'text-red-600';
            reviewReportList.appendChild(reportListItem);
            
            // 4. Tampilkan modal
            reviewModal.classList.remove('hidden');
        }


        // --- LOGIKA EVENT LISTENERS ---
        
        // A. Pemicu dari Tombol Tabel
        document.querySelectorAll('.action-btn-trigger').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const reportId = this.getAttribute('data-id');
                const action = this.getAttribute('data-action');
                
                // Ambil data dari TR (closest row)
                const row = this.closest('tr');
                const reportData = {
                    // Menggunakan operator OR (||) untuk memberikan nilai default jika dataset gagal
                    id: row.dataset.reportId || reportId,
                    type: row.dataset.reportType || 'Tipe Tidak Ditemukan',
                    target: row.dataset.reportTarget || 'Target Tidak Ditemukan',
                    priority: row.dataset.reportPriority || 'N/A',
                    summary: row.dataset.contentSummary || 'Ringkasan konten tidak tersedia.',
                };
                
                openReviewModal(reportData, action);
            });
        });
        
        // B. Aksi di Dalam Modal (Hapus Konten)
        actionDeleteBtn.addEventListener('click', function() {
            const reportId = reviewPostId.textContent;
            const notes = adminReviewNotes.value;
            const confirmation = confirm(`Yakin hapus konten untuk laporan ${reportId}?`);
            if (confirmation) {
                alert(`[SIMULASI] Laporan ${reportId} ditindak: Konten Dihapus. Catatan: ${notes}`);
                closeModal();
            }
        });
        
        // C. Aksi di Dalam Modal (Setujui)
        actionApproveBtn.addEventListener('click', function() {
            const reportId = reviewPostId.textContent;
            const notes = adminReviewNotes.value;
            alert(`[SIMULASI] Laporan ${reportId} disetujui (Tidak Melanggar). Catatan: ${notes}`);
            closeModal();
        });

        // D. Penutupan Modal
        closeReviewModalBtn.addEventListener('click', closeModal);
        reviewModal.addEventListener('click', function(event) {
            if (event.target === reviewModal) {
                closeModal();
            }
        });
    });
</script>
@endpush