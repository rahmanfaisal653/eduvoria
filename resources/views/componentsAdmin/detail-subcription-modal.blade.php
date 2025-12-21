<div id="subs-detail-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4 transform transition-all duration-300">
        <h3 class="text-xl font-bold text-cyan-600 border-b pb-2 mb-4">
            Detail Langganan <span id="modal-subs-id">#SUB-XXXX</span>
        </h3>
        
        <div class="space-y-3 mb-6 max-h-80 overflow-y-auto">
            <div class="space-y-2 text-sm text-gray-700">
                <div class="flex justify-between">
                    <span>Username:</span>
                    <strong id="modal-subs-username" class="text-gray-900"></strong>
                </div>
                <div class="flex justify-between">
                    <span>Start Date:</span>
                    <strong id="modal-subs-start"></strong>
                </div>
                <div class="flex justify-between">
                    <span>End Date:</span>
                    <strong id="modal-subs-end"></strong>
                </div>
                <div class="flex justify-between">
                    <span>Payment Method:</span>
                    <strong id="modal-subs-method"></strong>
                </div>

                <form id="form-update-status" action="" method="POST" class="mt-2 pt-2 border-t border-gray-100">
                    @csrf
    
                    <input type="hidden" name="user" id="input-user-hidden">
                    <input type="hidden" name="start_date" id="input-start-hidden">
                    <input type="hidden" name="end_date" id="input-end-hidden">
                    <label class="block text-xs font-bold text-gray-500 mb-1">Ubah Status Pembayaran:</label>
                    <div class="flex gap-2">
                        <select name="status" id="edit-subs-status" class="w-full border-gray-300 rounded-md text-sm focus:ring-cyan-500 focus:border-cyan-500 p-2 border">
                            <option value="paid">Paid (Lunas)</option>
                            <option value="pending">Pending (Menunggu)</option>
                            <option value="failed">Failed (Gagal)</option>
                            <option value="cancelled">Cancelled (Batal)</option>
                        </select>

                        <button type="submit" class="bg-cyan-600 text-white px-4 py-2 rounded-md text-xs font-bold hover:bg-cyan-700 transition">
                            Update
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="pt-4 border-t border-gray-100 space-y-2">
                <p class="text-sm font-semibold text-gray-800 mb-2">Zone Bahaya:</p>
                <form id="form-delete-subs" action="" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-2 rounded-lg bg-red-500 text-white font-semibold text-sm hover:bg-red-600 transition flex justify-center items-center gap-2">
                        <span>🚫</span> Hapus Langganan Paksa
                    </button>
                </form>
            </div>
        </div>

        <div class="flex justify-end pt-3">
            <button type="button" id="close-subs-modal" class="py-2 px-4 rounded-lg bg-gray-200 text-gray-800 font-semibold hover:bg-gray-300 transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('subs-detail-modal');
        const closeBtn = document.getElementById('close-subs-modal');
        const triggers = document.querySelectorAll('.subs-trigger');

        // Form Elements
        const formUpdate = document.getElementById('form-update-status');
        const formDelete = document.getElementById('form-delete-subs');
        const statusSelect = document.getElementById('edit-subs-status');

        // Hidden Inputs
        const inputUser = document.getElementById('input-user-hidden');
        const inputStart = document.getElementById('input-start-hidden');
        const inputEnd = document.getElementById('input-end-hidden');

        // Text Displays
        const modalId = document.getElementById('modal-subs-id');
        const modalUser = document.getElementById('modal-subs-username');
        const modalStart = document.getElementById('modal-subs-start');
        const modalEnd = document.getElementById('modal-subs-end');
        const modalMethod = document.getElementById('modal-subs-method');

        triggers.forEach(button => {
            button.addEventListener('click', function () {
                // 1. Ambil Data
                const id = this.getAttribute('data-id');
                const username = this.getAttribute('data-username');
                const start = this.getAttribute('data-start-date');
                const end = this.getAttribute('data-end-date');
                const method = this.getAttribute('data-payment-method');
                const status = this.getAttribute('data-status');

                // 2. Isi Teks Modal
                modalId.innerText = '#' + id;
                modalUser.innerText = username;
                modalStart.innerText = start;
                modalEnd.innerText = end;
                modalMethod.innerText = method;

                // 3. Isi Hidden Input
                if(inputUser) inputUser.value = username;
                if(inputStart) inputStart.value = start;
                if(inputEnd) inputEnd.value = end;
                
                // 4. Set Dropdown
                if(statusSelect) statusSelect.value = status.toLowerCase();

                // 5. PERBAIKAN URL ACTION (Tambah /admin)
                // Sesuai route list: admin/reports/subscribe/update/{id}
                
                if (formUpdate) {
                    formUpdate.action = '/admin/reports/subscribe/update/' + id;
                }

                if (formDelete) {
                    formDelete.action = '/admin/reports/subscribe/delete/' + id;
                }

                // 6. Tampilkan Modal
                modal.classList.remove('hidden');
            });
        });

        const closeModal = () => modal.classList.add('hidden');
        closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => { if(e.target === modal) closeModal(); });
    });
</script>