    <div id="subs-detail-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4 transform transition-all duration-300">
            <h3 class="text-xl font-bold text-cyan-600 border-b pb-2 mb-4">Detail Langganan <span id="subs-id">#SUB-XXXX</span></h3>
            
            <div class="space-y-3 mb-6 max-h-80 overflow-y-auto">
                <div class="space-y-1 text-sm">
                    <p>Pengguna: <strong id="subs-user"></strong></p>
                    <p>Jenis Laporan: <strong id="subs-report-type"></strong></p>
                    <p>Tanggal Laporan: <strong id="subs-date"></strong></p>
                    <p>Status Pembayaran: <span id="subs-payment-status" class="font-semibold"></span></p>
                </div>
                
                <div class="pt-3 border-t border-gray-100 space-y-2">
                    <p class="text-sm font-semibold text-gray-800">Tindakan Cepat:</p>
                    <button type="button" id="force-cancel-subs" class="w-full py-2 rounded-lg bg-red-500 text-white font-semibold text-sm hover:bg-red-600 transition">
                        Batalkan Langganan Paksa
                    </button>
                    <button type="button" id="mark-resolved-subs" class="w-full py-2 rounded-lg bg-green-500 text-white font-semibold text-sm hover:bg-green-600 transition">
                        Tandai Selesai & Aktifkan
                    </button>
                </div>
            </div>

            <div class="flex justify-end pt-3">
                <button type="button" id="close-subs-modal" onclick="document.getElementById('subs-detail-modal').classList.add('hidden')" class="py-2 px-4 rounded-lg bg-gray-300 text-gray-800 font-semibold hover:bg-gray-400 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
