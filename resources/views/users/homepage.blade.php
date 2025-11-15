@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <div class="">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- KOLOM KIRI & TENGAH: Umpan Beranda dan Add Post --}}
            <div class="lg:col-span-2 space-y-6">
                <h2 class="text-xl font-bold text-gray-800">Umpan Beranda</h2>

                {{-- CARD INPUT POSTINGAN BARU --}}
                <div class="bg-white p-4 rounded-xl shadow-lg border border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-full bg-gray-300 flex-shrink-0"></div>
                        <input
                            type="text"
                            placeholder="Apa yang ada di pikiranmu? Mulai postingan..."
                            class="w-full py-2 pl-3 text-gray-700 focus:outline-none focus:ring-0 text-sm"
                        />
                    </div>
                    
                    <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between items-center">
                        <div class="flex space-x-4 text-sm text-gray-500">
                            <button class="flex items-center space-x-1 hover:text-teal-600 transition">
                                🖼️
                                <span class="hidden sm:inline">Foto/Video</span>
                            </button>
                            <button class="flex items-center space-x-1 hover:text-teal-600 transition">
                                👥
                                <span class="hidden sm:inline">Tag Komunitas</span>
                            </button>
                        </div>
                        <button class="bg-teal-600 text-white py-1.5 px-4 rounded-lg text-sm font-semibold hover:bg-teal-700 transition shadow-md">
                            Kirim
                        </button>
                    </div>
                </div>
                
                {{-- KOLOM PENCARIAN FEED --}}
                <div class="relative">
                    <input
                        type="text"
                        placeholder="Cari Postingan, Pengguna, atau Topik..."
                        class="w-full rounded-xl border border-gray-300 py-3 pl-5 pr-12 text-gray-700 focus:border-teal-500 focus:ring-teal-500 shadow-sm"
                    />
                    <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                        🔍
                    </span>
                </div>

                {{-- STRUKTUR POSTINGAN DINAMIS --}}
                @foreach ($posts as $post)
                    @include('componentsUser.post-card', ['post' => $post])
                @endforeach
            </div>

            {{-- KOLOM KANAN: SIDEBAR --}}
            <aside class="space-y-6">
                <div class="rounded-xl bg-white p-5 shadow-lg">
                    <h3 class="mb-4 text-lg font-bold text-gray-800">Postingan Trending</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="h-12 w-12 flex-shrink-0 rounded-md bg-teal-100"></div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800 hover:text-teal-600 cursor-pointer">10 Tips Produktif Saat untuk Bekerja dari Rumah</p>
                                <p class="text-xs text-gray-500">Berita & Sains</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="h-12 w-12 flex-shrink-0 rounded-md bg-orange-100"></div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800 hover:text-teal-600 cursor-pointer">Wawancara Eksklusif dengan CEO Energetic Social</p>
                                <p class="text-xs text-gray-500">Bisnis & Finansial</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="h-12 w-12 flex-shrink-0 rounded-md bg-blue-100"></div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800 hover:text-teal-600 cursor-pointer">Fotografi Potret Abadikan Momen Terbaikmu</p>
                                <p class="text-xs text-gray-500">Fotografi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl bg-white p-5 shadow-lg">
                    <h3 class="mb-4 text-lg font-bold text-gray-800">Apa yang Baru</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="h-12 w-12 flex-shrink-0 rounded-md bg-gray-200"></div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Fitur 'Cerita Telah Hadir'</p>
                                <p class="text-xs text-gray-500">Bagikan momen singkat dan interaktif dengan teman-teman Anda.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="h-12 w-12 flex-shrink-0 rounded-md bg-gray-200"></div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Peningkatan Filter Pencarian</p>
                                <p class="text-xs text-gray-500">Temukan apa yang kamu cari dengan cepat dari menu baru kami.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl bg-white p-5 text-center shadow-lg">
                    <div class="mx-auto h-10 w-10 text-teal-500 flex items-center justify-center">🏆</div>
                    <h3 class="mt-2 text-lg font-bold text-gray-800">Tantangan Komunitas</h3>
                    <p class="text-sm text-gray-600">Bergabunglah dalam tantangan bulanan kami dan menangkan hadiah menarik!</p>
                    <button class="mt-4 rounded-full border border-teal-500 px-5 py-1.5 text-sm font-semibold text-teal-600 hover:bg-teal-50">
                        Lihat Tantangan
                    </button>
                </div>

                <div class="rounded-xl bg-white p-5 text-center shadow-lg">
                    <div class="mx-auto h-10 w-10 text-teal-500 flex items-center justify-center">📅</div>
                    <h3 class="mt-2 text-lg font-bold text-gray-800">Acara Mendatang</h3>
                    <p class="text-sm text-gray-600">Jangan lewatkan webinar dan pertemuan online kami yang menarik.</p>
                    <button class="mt-4 rounded-full bg-teal-500 px-5 py-1.5 text-sm font-semibold text-white hover:bg-teal-600">
                        Jelajahi Acara
                    </button>
                </div>
            </aside>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Elemen Modal Laporan (Diasumsikan ada di app.blade) ---
        const reportModal = document.getElementById('report-modal');
        const reportedPostIdInput = document.getElementById('reported-post-id');
        
        // FUNGSI untuk membuka modal laporan (didefinisikan di app.blade)
        function openReportModal(postId) {
            if(reportModal) {
                if (reportedPostIdInput) reportedPostIdInput.value = postId; 
                reportModal.classList.remove('hidden');
            }
        }

        // 1. Logika Toggle Dropdown Laporan (Tiga Titik)
        const toggleButtons = document.querySelectorAll('.report-toggle-btn');
        const allMenus = document.querySelectorAll('.report-menu-content');
        
        function closeAllReportMenus() {
            allMenus.forEach(menu => { menu.classList.add('hidden'); });
        }

        toggleButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.stopPropagation(); 
                const targetId = button.getAttribute('data-target');
                const targetMenu = document.getElementById(targetId);
                const isHidden = targetMenu.classList.contains('hidden');
                closeAllReportMenus();
                if (isHidden) { targetMenu.classList.remove('hidden'); }
            });
        });
        
        // 2. Logika Menutup Dropdown Saat Klik di Luar
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.report-toggle-btn') && !event.target.closest('.report-menu-content')) {
                closeAllReportMenus();
            }
        });

        // 3. Logika Membuka Modal Saat Klik "Laporkan Postingan"
        allMenus.forEach(menu => {
            const reportLink = menu.querySelector('a');
            reportLink.addEventListener('click', function(event) {
                event.preventDefault();
                closeAllReportMenus(); 
                
                // Ambil ID Postingan (dinamis dari data-target ID)
                const postId = menu.id; 
                openReportModal(postId);
            });
        });
    });
</script>
@endpush
