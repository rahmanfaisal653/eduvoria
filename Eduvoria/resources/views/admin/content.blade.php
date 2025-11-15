@extends('layouts.appadmin')

@section('title', 'Konten & Postingan')
@section('page_title', 'Manajemen Konten & Postingan')

@section('content')
    <section class="space-y-6">
        <h2 class="text-2xl font-semibold text-gray-800">Manajemen Konten Publik</h2>

        {{-- Metrik Konten --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-cyan-500">
                <p class="text-sm font-medium text-gray-500">Total Postingan</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">15.8K</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-teal-500">
                <p class="text-sm font-medium text-gray-500">Postingan Gambar/Video</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">9.2K</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-red-500">
                <p class="text-sm font-medium text-gray-500">Perlu Review Cepat</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">12</p>
            </div>
        </div>

        {{-- Tabel Postingan --}}
        <div class="bg-white rounded-xl shadow-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-cyan-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Konten</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Penulis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    {{-- Menggunakan data $posts yang akan dikirim dari Controller --}}
                    @forelse ($posts as $post)
                    <tr class="hover:bg-gray-50" data-post-id="{{ $post['id'] }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $post['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($post['content'], 40) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $post['author'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $post['status_color'] }}">
                                {{ $post['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="#" class="view-post-btn text-teal-600 hover:text-teal-900" data-id="{{ $post['id'] }}">Lihat</a>
                            @if ($post['status'] != 'Dilaporkan')
                            <a href="#" class="delete-post-btn text-red-600 hover:text-red-900" data-id="{{ $post['id'] }}">Hapus</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada postingan untuk ditampilkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    {{-- Modal Lihat Detail, Hapus, Review akan diletakkan di appadmin.blade.php atau di-include di sini --}}

    @include('componentsAdmin.view-post-modal')
    @include('componentsAdmin.delete-post-modal')


@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- ELEMEN MODAL VIEW ---
        const viewModal = document.getElementById('view-modal');
        const viewPostId = document.getElementById('view-post-id');
        const viewPostText = document.getElementById('view-post-text');
        const viewPostAuthor = document.getElementById('view-post-author');
        const viewPostStatus = document.getElementById('view-post-status');
        const viewPostButtons = document.querySelectorAll('.view-post-btn');
        
        // --- ELEMEN MODAL DELETE ---
        const deleteModal = document.getElementById('delete-modal'); 
        const confirmDeleteButton = document.getElementById('confirm-delete-button');
        const deletePostButtons = document.querySelectorAll('.delete-post-btn');
        
        // --- FUNGSI MODAL UTILITY ---
        function openModal(modal) { modal.classList.remove('hidden'); }
        function closeModal(modal) { modal.classList.add('hidden'); } // Mendefinisikan closeModal secara eksplisit

        // --- HANDLER UTAMA UNTUK MODAL VIEW (Lihat) ---
        viewPostButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Dapatkan data dari baris tabel (<tr>)
                const row = this.closest('tr');
                if (!row) return alert('Error: Baris postingan tidak ditemukan.');

                const postId = this.getAttribute('data-id');
                const contentText = row.cells[1].textContent.trim();
                const author = row.cells[2].textContent.trim();
                const statusSpan = row.cells[3].querySelector('span');
                const status = statusSpan.textContent.trim();
                const statusColorClass = statusSpan.className; // Ambil semua kelas untuk warna

                // Logika untuk menampilkan data
                if (row) {
                    // Isi data ke modal
                    viewPostId.textContent = `#${postId}`;
                    viewPostText.textContent = contentText; // CATATAN: Ini adalah konten terpotong
                    viewPostAuthor.textContent = author;
                    viewPostStatus.textContent = status;
                    
                    // Logic warna status
                    const statusTextElement = document.getElementById('view-post-status');
                    // Reset classes and apply new color based on the status span class
                    statusTextElement.className = 'font-semibold'; 
                    
                    // Cari kelas warna teks dari statusColorClass (misalnya: 'text-red-800')
                    const textColorClassMatch = statusColorClass.match(/text-([a-z]+-\d{1,3})/);
                    if (textColorClassMatch && textColorClassMatch[0]) {
                        statusTextElement.classList.add(textColorClassMatch[0]);
                    } else {
                        statusTextElement.classList.add('text-gray-800'); // Fallback
                    }
                    
                    // Buka modal
                    openModal(viewModal);
                } else {
                    alert('Postingan tidak ditemukan.');
                }
            });
        });

        // --- HANDLER UTAMA UNTUK MODAL DELETE (Hapus) ---
        deletePostButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const postId = this.getAttribute('data-id');
                
                // 1. Isi ID Postingan yang akan dihapus ke tombol konfirmasi
                confirmDeleteButton.setAttribute('data-id', postId);
                
                // 2. Isi ID Postingan ke teks di dalam modal
                // Menggunakan ID 'delete-post-id' dari komponen delete-post-modal
                document.getElementById('delete-post-id').textContent = `#${postId}`; 
                
                // 3. Buka modal
                openModal(deleteModal);
            });
        });
        
        // --- AKSI PENGHAPUSAN (TOMBOL KONFIRMASI) ---
        if (confirmDeleteButton) {
            confirmDeleteButton.addEventListener('click', function() {
                const postId = this.getAttribute('data-id');
                
                // Logika penghapusan (Simulasi)
                alert(`Simulasi: Postingan ID ${postId} berhasil dihapus dari database.`);
                closeModal(deleteModal);
                
                // Di sini Anda akan mengirim permintaan DELETE/AJAX ke server Laravel
            });
        }
        
        // --- HANDLER PENUTUPAN MODAL BACKDROP (Digabungkan) ---
        [viewModal, deleteModal].forEach(modal => {
            if (modal) {
                modal.addEventListener('click', function(event) {
                    // Tutup saat klik di backdrop
                    if (event.target === modal) {
                        closeModal(modal);
                    }
                });
            }
        });

        // Tambahkan fungsi lain Anda di sini
        // ...
    });
</script>
@endpush
