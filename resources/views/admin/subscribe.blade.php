@extends('layouts.appadmin')

@section('title', 'Laporan Langganan')
@section('page_title', 'Tinjauan Laporan Langganan (Subscription)')

@section('content')
    <section class="space-y-6">
        
        <h2 class="text-2xl font-semibold text-gray-800">Daftar Laporan Masalah Transaksi</h2>

        {{-- Metrik Ringkasan Subscribe (Diambil dari halaman laporan langganan sebelumnya) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <div class="bg-white p-5 rounded-xl shadow-lg border-b-4 border-teal-500">
                <p class="text-sm font-medium text-gray-500">Revenue Bulan Ini</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">Rp 12.5 Jt</p>
                <p class="text-sm text-green-600 mt-2">▲ 7% dari Bulan Lalu</p>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-lg border-b-4 border-red-500">
                <p class="text-sm font-medium text-gray-500">Laporan Gagal/Masalah Baru</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">3</p>
                <p class="text-sm text-red-600 mt-2">Perlu Ditindaklanjuti!</p>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-lg border-b-4 border-cyan-500">
                <p class="text-sm font-medium text-gray-500">Total Pelanggan Aktif</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">450</p>
                <p class="text-sm text-green-600 mt-2">▲ 30 Pengguna Baru</p>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-lg border-b-4 border-gray-400">
                <p class="text-sm font-medium text-gray-500">Tingkat Berhenti Langganan</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">4.2%</p>
                <p class="text-sm text-red-600 mt-2">▲ 0.5% (Tingkat Kenaikan)</p>
            </div>
        </div>

        {{-- Tabel Laporan Subscribe --}}
        <div class="bg-white rounded-xl shadow-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-cyan-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">ID Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Jenis Laporan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    {{-- Loop data $subsReports dari Controller --}}
                    @forelse ($subsReports as $report)
                    <tr class="hover:bg-gray-50" data-subs-id="{{ $report['id'] }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $report['user'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $report['type'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $report['date'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $report['status_color'] }}">
                                {{ $report['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button 
                                class="subs-trigger text-white bg-cyan-600 hover:bg-cyan-700 py-1 px-3 rounded text-xs" 
                                data-id="{{ $report['id'] }}"
                                data-user="{{ $report['user'] }}"
                                data-type="{{ $report['type'] }}"
                                data-date="{{ $report['date'] }}"
                                data-status="{{ $report['status'] }}"
                            >
                                Lihat Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada laporan langganan yang bermasalah.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Modal Detail Laporan Subscribe --}}
    @include('componentsAdmin.detail-subcription-modal')

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- ELEMEN MODAL ---
        const subsDetailModal = document.getElementById('subs-detail-modal');
        const subsTriggerButtons = document.querySelectorAll('.subs-trigger');
        const markResolvedSubsButton = document.getElementById('mark-resolved-subs');
        const forceCancelSubsButton = document.getElementById('force-cancel-subs');
        
        // --- Modal Display Elements ---
        const subsIdSpan = document.getElementById('subs-id');
        const subsUserSpan = document.getElementById('subs-user');
        const subsReportTypeSpan = document.getElementById('subs-report-type');
        const subsDateSpan = document.getElementById('subs-date');
        const subsPaymentStatusSpan = document.getElementById('subs-payment-status');
        
        // --- FUNGSI UTILITY ---
        function closeModal() { subsDetailModal.classList.add('hidden'); }
        
        // --- LOGIKA KONTROL MODAL ---
        
        // Logika Membuka Modal Subscribe
        subsTriggerButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Ambil data dari data-attribute tombol
                const subsId = this.getAttribute('data-id');
                const subsUser = this.getAttribute('data-user');
                const subsType = this.getAttribute('data-type');
                const subsDate = this.getAttribute('data-date');
                const subsStatus = this.getAttribute('data-status');
        
                // Isi Modal
                subsIdSpan.textContent = subsId;
                subsUserSpan.textContent = subsUser;
                subsReportTypeSpan.textContent = subsType;
                subsDateSpan.textContent = subsDate;
                
                // Set Status dan Warna
                subsPaymentStatusSpan.textContent = subsStatus;
                subsPaymentStatusSpan.classList.remove('text-red-600', 'text-yellow-600', 'text-green-600');
                
                if (subsStatus === 'Gagal') { 
                    subsPaymentStatusSpan.classList.add('text-red-600'); 
                } else if (subsStatus === 'Pending') { 
                    subsPaymentStatusSpan.classList.add('text-yellow-600'); 
                } else { 
                    subsPaymentStatusSpan.classList.add('text-green-600'); 
                }

                // Tampilkan modal
                subsDetailModal.classList.remove('hidden');
            });
        });

        // Logika Menutup Modal Subscribe (Backdrop)
        subsDetailModal.addEventListener('click', function(event) {
            if (event.target === subsDetailModal) {
                closeModal();
            }
        });

        // Logika Aksi: Mark Resolved
        markResolvedSubsButton.addEventListener('click', function() {
            const subsId = subsIdSpan.textContent;
            alert(`[SIMULASI] Langganan ${subsId} ditandai sebagai Selesai dan pengguna diaktifkan.`);
            closeModal();
        });
        
        // Logika Aksi: Force Cancel
        forceCancelSubsButton.addEventListener('click', function() {
            const subsId = subsIdSpan.textContent;
            const confirmation = confirm(`Yakin batalkan langganan ${subsId} secara paksa?`);
            if (confirmation) {
                alert(`[SIMULASI] Langganan ${subsId} dibatalkan paksa.`);
                closeModal();
            }
        });
    });
</script>
@endpush
