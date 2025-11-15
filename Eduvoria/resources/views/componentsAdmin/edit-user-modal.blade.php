<div id="edit-user-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4 transform transition-all duration-300">
            <div class="text-center mb-4">
                <h3 id="edit-modal-title" class="text-2xl font-bold text-teal-600 mb-1">Edit Detail Pengguna</h3>
                <p class="text-sm text-gray-600">Perbarui informasi akun.</p>
            </div>

            <form id="edit-user-form" class="space-y-4">
                
                <!-- Bidang Email -->
                <div>
                    <label for="edit-email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="edit-email" required class="mt-1 w-full rounded-lg border border-gray-300 py-2 px-3 text-sm focus:border-teal-500 focus:ring-teal-500"/>
                </div>
                
                <!-- Bidang Username -->
                <div>
                    <label for="edit-username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="edit-username" required class="mt-1 w-full rounded-lg border border-gray-300 py-2 px-3 text-sm focus:border-teal-500 focus:ring-teal-500"/>
                </div>

                <!-- ID Pengguna yang Diedit (Hidden) -->
                <input type="hidden" id="edited-user-id" value="">
                
                <!-- Tombol Aksi -->
                <div class="pt-4 space-y-3">
                    
                    <!-- Baris Tombol Simpan & Batal -->
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancel-edit-user" class="py-2 px-4 rounded-lg text-gray-600 border border-gray-300 hover:bg-gray-100 transition">Batal</button>
                        <button type="submit" class="py-2 px-4 rounded-lg bg-teal-600 text-white font-semibold hover:bg-teal-700 transition">Simpan Perubahan</button>
                    </div>

                    <!-- Tombol Hapus Akun -->
                    <button type="button" id="delete-user-button" class="w-full py-2 rounded-lg bg-red-500 text-white font-semibold hover:bg-red-600 transition">Hapus Akun Permanen</button>

                </div>
            </form>
        </div>
    </div>