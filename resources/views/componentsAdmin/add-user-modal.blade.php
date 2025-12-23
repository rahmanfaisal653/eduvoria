    <div id="add-user-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4 transform transition-all duration-300">
            <div class="text-center mb-4">
                <h3 class="text-2xl font-bold text-teal-600 mb-1">Tambah Pengguna Baru 👥</h3>
                <p class="text-sm text-gray-600">Masukkan detail akun pengguna yang akan didaftarkan.</p>
            </div>

            <form id="add-user-form" class="space-y-4" method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                @csrf
                <!-- Bidang Email -->
                <div>
                    <label for="new-email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="new-email" required placeholder="example@edu.com" class="mt-1 w-full rounded-lg border border-gray-300 py-2 px-3 text-sm focus:border-teal-500 focus:ring-teal-500"/>
                </div>
                
                <!-- Bidang Username -->
                <div>
                    <label for="new-username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="name" id="new-username" required placeholder="username_baru" class="mt-1 w-full rounded-lg border border-gray-300 py-2 px-3 text-sm focus:border-teal-500 focus:ring-teal-500"/>
                </div>

                <!-- Bidang Password -->
                <div>
                    <label for="new-password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="new-password" required placeholder="Minimal 8 karakter" class="mt-1 w-full rounded-lg border border-gray-300 py-2 px-3 text-sm focus:border-teal-500 focus:ring-teal-500"/>
                </div>

                <!-- Bidang Status -->
                 <div>
                    <label for="new-status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="new-status" class="mt-1 w-full rounded-lg border border-gray-300 py-2 px-3 text-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="active">Active</option>
                        <option value="blocked">Blocked</option>
                        </select>
                </div>
                
                <!-- Tombol Aksi -->
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" id="cancel-add-user" class="py-2 px-4 rounded-lg text-gray-600 border border-gray-300 hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" value="save" class="py-2 px-4 rounded-lg bg-teal-600 text-white font-semibold hover:bg-teal-700 transition">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>

<script>
    const addBtn = document.getElementById('add-user-btn'); 
    const addModal = document.getElementById('add-user-modal');
    const cancelAddBtn = document.getElementById('cancel-add-user');
    const addForm = document.getElementById('add-user-form');

    function openAddModal() { addModal.classList.remove('hidden'); }
    function closeAddModal() { addModal.classList.add('hidden'); addForm.reset(); }

    addBtn.addEventListener('click', openAddModal);
    cancelAddBtn.addEventListener('click', closeAddModal);
</script>