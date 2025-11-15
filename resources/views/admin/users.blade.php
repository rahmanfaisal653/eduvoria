@extends('layouts.appadmin')

@section('title', 'Manajemen Pengguna')
@section('page_title', 'Manajemen Pengguna')

@section('content')
    <section class="space-y-6">
        <h2 class="text-2xl font-semibold text-gray-800">Daftar Pengguna Aktif</h2>

        {{-- Kontrol Filter/Pencarian --}}
        <div class="bg-white p-4 rounded-xl shadow-md flex justify-between items-center space-x-4">
            <input
                type="text"
                placeholder="Cari berdasarkan Nama atau Email..."
                class="w-full max-w-sm rounded-lg border border-gray-300 py-2 px-3 text-sm focus:border-teal-500 focus:ring-teal-500"
            />
            <select class="rounded-lg border border-gray-300 py-2 px-3 text-sm focus:border-teal-500 focus:ring-teal-500">
                <option>Filter Status: Semua</option>
                <option>Status: Aktif</option>
                <option>Status: Diblokir</option>
            </select>
            <button id="add-user-btn" class="bg-teal-600 text-white py-2 px-4 rounded-lg text-sm font-semibold hover:bg-teal-700">
                Tambah Pengguna Baru
            </button>
        </div>

        {{-- Tabel Pengguna --}}
        <div class="bg-white rounded-xl shadow-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-teal-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Bergabung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    {{-- Menggunakan data $users yang dikirim dari Controller --}}
                    @foreach ($users as $user)
                    <tr class="hover:bg-gray-50" data-user-id="{{ $user['id'] }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user['name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user['email'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user['status_color'] }}">
                                {{ $user['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user['joined'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            @if (in_array('Edit', $user['actions']))
                                <a href="#" class="edit-user-btn text-teal-600 hover:text-teal-900" data-id="{{ $user['id'] }}" data-email="{{ $user['email'] }}" data-username="{{ $user['name'] }}">Edit</a>
                            @endif
                            @if (in_array('Blokir', $user['actions']))
                                <button type="button" class="block-user-btn text-red-600 hover:text-red-900" data-id="{{ $user['id'] }}" data-username="{{ $user['name'] }}">Blokir</button>
                            @endif
                            @if (in_array('Verifikasi', $user['actions']))
                                <a href="#" class="text-teal-600 hover:text-teal-900">Verifikasi</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- MODAL TAMBAH PENGGUNA --}}
    @include('componentsAdmin.add-user-modal')

    {{-- MODAL EDIT PENGGUNA --}}
    @include('componentsAdmin.edit-user-modal')

    {{-- MODAL BLOKIR PENGGUNA --}}
    @include('componentsAdmin.block-user-modal')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- MODAL TAMBAH PENGGUNA ---
        const addBtn = document.getElementById('add-user-btn'); 
        const addModal = document.getElementById('add-user-modal');
        const cancelAddBtn = document.getElementById('cancel-add-user');
        const addForm = document.getElementById('add-user-form');
        
        function openAddModal() { addModal.classList.remove('hidden'); }
        function closeAddModal() { addModal.classList.add('hidden'); addForm.reset(); }
        
        addBtn.addEventListener('click', openAddModal);
        cancelAddBtn.addEventListener('click', closeAddModal);

        addForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Simulasi: Menambah pengguna baru...');
            alert('Pengguna baru berhasil ditambahkan! (Simulasi)');
            closeAddModal();
        });
        
        addModal.addEventListener('click', function(e) {
            if (e.target === addModal) { closeAddModal(); }
        });

        // --- MODAL EDIT PENGGUNA ---
        const editButtons = document.querySelectorAll('.edit-user-btn');
        const editModal = document.getElementById('edit-user-modal');
        const cancelEditBtn = document.getElementById('cancel-edit-user');
        const deleteBtn = document.getElementById('delete-user-button');
        const editForm = document.getElementById('edit-user-form');
        
        const editEmailInput = document.getElementById('edit-email');
        const editUsernameInput = document.getElementById('edit-username');
        const editedUserIdInput = document.getElementById('edited-user-id');

        function openEditModal(userData) {
            editEmailInput.value = userData.email;
            editUsernameInput.value = userData.username;
            editedUserIdInput.value = userData.id;
            
            // Perbarui judul modal
            document.getElementById('edit-modal-title').textContent = `Edit Detail ${userData.username}`;

            editModal.classList.remove('hidden');
        }

        function closeEditModal() {
            editModal.classList.add('hidden');
            editForm.reset();
        }

        // 1. Logika Membuka Modal Edit dari tombol di tabel
        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const userId = this.getAttribute('data-id');
                const username = this.getAttribute('data-username');
                const email = this.getAttribute('data-email');

                const userData = { id: userId, username: username, email: email };
                openEditModal(userData);
            });
        });

        // 2. Logika Menutup Modal Edit
        cancelEditBtn.addEventListener('click', closeEditModal);
        editModal.addEventListener('click', function(e) {
            if (e.target === editModal) { closeEditModal(); }
        });

        // 3. Logika Submit Simpan Perubahan
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const newUsername = editUsernameInput.value;
            console.log(`Simulasi: Mengupdate ID ${editedUserIdInput.value} menjadi ${newUsername}`);
            alert(`Data untuk ${newUsername} berhasil diperbarui! (Simulasi)`);
            closeEditModal();
        });

        // 4. Logika Hapus Akun Permanen
        deleteBtn.addEventListener('click', function() {
            const username = editUsernameInput.value;
            const confirmation = confirm(`ANDA YAKIN INGIN MENGHAPUS AKUN ${username.toUpperCase()} secara PERMANEN?`);
            
            if (confirmation) {
                console.log(`Simulasi: Menghapus akun ${username}`);
                alert(`Akun ${username} berhasil dihapus! (Simulasi)`);
                closeEditModal();
            }
        });

        // --- MODAL BLOKIR PENGGUNA ---
        const blockUserModal = document.getElementById('block-user-modal');
        const confirmBlockButton = document.getElementById('confirm-block-button');
        const blockButtons = document.querySelectorAll('.block-user-btn');
        
        function openBlockModal(userId, username) {
            confirmBlockButton.setAttribute('data-id', userId);
            // PERBAIKAN: Menggunakan ID yang benar: 'blokir-post-id'
            document.getElementById('blokir-post-id').textContent = username.toUpperCase(); 
            blockUserModal.classList.remove('hidden');
        }
        function closeBlockModal() {
            blockUserModal.classList.add('hidden');
            confirmBlockButton.removeAttribute('data-id');
        }
        
        // 1. Logika Membuka Modal Blokir
        blockButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const userId = this.getAttribute('data-id');
                const username = this.getAttribute('data-username');
                openBlockModal(userId, username);
            });
        });
        
        // 2. Logika Menutup Modal Blokir (Tombol Batal menggunakan inline JS)

        // 3. Logika Konfirmasi Blokir
        confirmBlockButton.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            const username = document.getElementById('blokir-post-id').textContent;
            
            console.log(`Simulasi: Blokir pengguna ID ${userId} (${username})`);
            alert(`Pengguna ${username} berhasil diblokir! (Simulasi)`);
            
            closeBlockModal();
        });
        
        // 4. Logika Menutup Modal Blokir (Backdrop)
        blockUserModal.addEventListener('click', function(e) {
            // Kita perlu menangani penutupan di luar tombol Batal yang sudah diatur secara inline
            if (e.target === blockUserModal) {
                closeBlockModal();
            }
        });
    });
</script>
@endpush
