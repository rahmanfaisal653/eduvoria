<div id="edit-user-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4 transform transition-all duration-300">
        <div class="text-center mb-4">
            <h3 id="edit-modal-title" class="text-2xl font-bold text-teal-600 mb-1">Edit Detail Pengguna</h3>
            <p class="text-sm text-gray-600">Perbarui informasi dan status akun.</p>
        </div>

        {{-- Form Action dikosongkan dulu, nanti diisi via JavaScript --}}
        <form id="edit-user-form" class="space-y-4" method="POST" action="#">
            @csrf

            <div>
                <label for="edit-email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="edit-email" required 
                    class="mt-1 w-full rounded-lg border border-gray-300 py-2 px-3 text-sm focus:border-teal-500 focus:ring-teal-500"/>
            </div>
            
            <div>
                <label for="edit-username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="name" id="edit-username" required 
                    class="mt-1 w-full rounded-lg border border-gray-300 py-2 px-3 text-sm focus:border-teal-500 focus:ring-teal-500"/>
            </div>

            <div>
                <label for="edit-status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="edit-status" 
                    class="mt-1 w-full rounded-lg border border-gray-300 py-2 px-3 text-sm focus:border-teal-500 focus:ring-teal-500">
                    <option value="active">Active</option>
                    <option value="blocked">Blocked</option>
                </select>
            </div>

            <input type="hidden" name="id" id="edited-user-id">
            
            <div class="pt-4 space-y-3">
                
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancel-edit-user" class="py-2 px-4 rounded-lg text-gray-600 border border-gray-300 hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="py-2 px-4 rounded-lg bg-teal-600 text-white font-semibold hover:bg-teal-700 transition">Simpan Perubahan</button>
                </div>

                <hr class="border-gray-200">

                <button type="button" id="delete-user-button" class="w-full py-2 rounded-lg bg-red-500 text-white font-semibold hover:bg-red-600 transition">Hapus Akun Permanen</button>
            </div>
        </form>
    </div>
</div>

<script>
// --- MODAL EDIT PENGGUNA ---
    const editButtons = document.querySelectorAll('.edit-user-btn');
    const editModal = document.getElementById('edit-user-modal');
    const cancelEditBtn = document.getElementById('cancel-edit-user');
    const deleteBtn = document.getElementById('delete-user-button');
    const editForm = document.getElementById('edit-user-form');
    
    // Elemen Input
    const editEmailInput = document.getElementById('edit-email');
    const editUsernameInput = document.getElementById('edit-username');
    const editStatusInput = document.getElementById('edit-status'); 
    const editPasswordInput = document.getElementById('edit-password'); 
    const editedUserIdInput = document.getElementById('edited-user-id');

    // Fungsi Buka Modal & Isi Data
    function openEditModal(userData) {
        // 1. Isi nilai input form
        editEmailInput.value = userData.email;
        editUsernameInput.value = userData.username;
        editedUserIdInput.value = userData.id;
        
        // 2. Isi nilai dropdown status
        if(editStatusInput) {
            editStatusInput.value = userData.status;
        }

        // 3. Reset Password jadi kosong (Supaya password lama tidak tertimpa kalau tidak diisi)
        if(editPasswordInput) {
            editPasswordInput.value = ''; 
        }

        // 4. PENTING: Ubah URL Action Form (Sesuai Route POST kamu)
        // URL ini cocok dengan: Route::post('/users/update/{id}', ...)
        editForm.action = `/admin/users/update/${userData.id}`;

        // 5. Update Judul & Tampilkan
        document.getElementById('edit-modal-title').textContent = `Edit Detail ${userData.username}`;
        editModal.classList.remove('hidden');
    }

    function closeEditModal() {
        editModal.classList.add('hidden');
        editForm.reset();
        editForm.action = '#'; 
    }

    // 1. Event Listener Tombol Edit di Tabel
    editButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Ambil data dari atribut data-*
            const userId = this.getAttribute('data-id');
            const username = this.getAttribute('data-username');
            const email = this.getAttribute('data-email');
            const status = this.getAttribute('data-status');

            const userData = { 
                id: userId, 
                username: username, 
                email: email,
                status: status 
            };
            
            openEditModal(userData);
        });
    });

    // 2. Event Listener Tutup Modal
    cancelEditBtn.addEventListener('click', closeEditModal);
    editModal.addEventListener('click', function(e) {
        if (e.target === editModal) { closeEditModal(); }
    });

    // 3. LOGIKA HAPUS AKUN (DELETE)
    deleteBtn.addEventListener('click', function() {
        const userId = editedUserIdInput.value;
        const username = editUsernameInput.value;
        
        const confirmation = confirm(`PERINGATAN: Hapus user ${username}? Data hilang permanen.`);
        
        if (confirmation) {
            // Karena pakai GET, cukup pindah halaman saja
            window.location.href = `/admin/users/delete/${userId}`;
        }
    });
</script>