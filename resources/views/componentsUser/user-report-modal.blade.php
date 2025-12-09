<div id="user-report-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md transform transition-all scale-100">
        
        {{-- Header --}}
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">⚠️ Laporkan Konten</h3>
            <button onclick="closeUserReportModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>

        {{-- Form --}}
        <form action="{{ route('user.report.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            
            {{-- 1. CONTENT_SUMMARY (Target Laporan) --}}
            {{-- Ini akan mengisi kolom 'Target' di tabel admin --}}
            <input type="hidden" name="content_summary" id="report-content-summary">

            {{-- Preview Visual (Biar user tau apa yg dilaporin) --}}
            <div class="bg-gray-50 p-3 rounded-lg border text-sm text-gray-600 mb-2">
                Melaporkan: <span id="preview-summary" class="font-bold text-gray-800">...</span>
            </div>

            {{-- 2. TYPE (Jenis Pelanggaran) --}}
            {{-- Ini akan mengisi kolom 'Tipe Pelanggaran' di tabel admin --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Apa masalahnya?</label>
                <select name="type" required class="w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500 p-2.5">
                    <option value="" disabled selected>Pilih alasan...</option>
                    {{-- Value ini harus sama dengan teks yang mau muncul di tabel admin --}}
                    <option value="Spam">Spam</option>
                    <option value="Hate Speech">Hate Speech (Ujaran Kebencian)</option>
                    <option value="False News">False News (Hoax)</option>
                    <option value="Harassment">Harassment (Pelecehan)</option>
                    <option value="Inappropriate">Konten Tidak Pantas</option>
                    <option value="Other">Lainnya</option>
                </select>
            </div>

            {{-- 3. DESCRIPTION (Deskripsi Tambahan) --}}
            {{-- Ini opsional, tapi berguna buat admin --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Detail Tambahan (Opsional)</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500 p-2.5" placeholder="Ceritakan lebih detail..."></textarea>
            </div>

            {{-- 4. Foto (Optional) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lampirkan Foto (Opsional)</label>
                <input type="file" name="foto" id="report-foto" accept=".png, .jpeg, .jpeg"
                       class="w-full rounded-lg border border-gray-300 p-2.5 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100"/>
            </div>

            {{-- Tombol --}}
            <div class="pt-2">
                <button type="submit" class="w-full bg-red-600 text-white font-bold py-2.5 rounded-lg hover:bg-red-700 transition shadow-lg">
                    Kirim Laporan
                </button>
                <button type="button" onclick="closeUserReportModal()" class="w-full mt-2 text-gray-500 text-sm hover:underline py-1">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script Pendukung (Simpan di bawah html modal ini) --}}
<script>
    function openUserReportModal(summaryContent) {
        // Isi input hidden agar masuk ke database
        document.getElementById('report-content-summary').value = summaryContent;
        // Tampilkan teks preview
        document.getElementById('preview-summary').textContent = summaryContent;
        // Buka modal
        document.getElementById('user-report-modal').classList.remove('hidden');
    }

    function closeUserReportModal() {
        document.getElementById('user-report-modal').classList.add('hidden');
    }
</script>