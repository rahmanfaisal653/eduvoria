@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex gap-8 justify-center">
  
            <div class="w-full lg:w-2/3 space-y-6">
            <h2 class="text-xl font-bold text-gray-800">Umpan Beranda</h2>

    
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-xl shadow-lg border border-gray-100">
                @csrf
                <div class="flex items-start space-x-3">
                    @if(Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" 
                             alt="{{ Auth::user()->name }}" 
                             class="h-10 w-10 rounded-full object-cover flex-shrink-0">
                    @else
                        <div class="h-10 w-10 rounded-full bg-gray-300 flex-shrink-0 flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <textarea
                        name="content"
                        id="content"
                        rows="3"
                        placeholder="Apa yang ada di pikiranmu? Mulai postingan..."
                        class="w-full py-2 pl-3 text-gray-700 focus:outline-none focus:ring-0 text-sm resize-none"
                        required
                    ></textarea>
                </div>
                
                <!-- Preview Image -->
                <div id="imagePreview" class="mt-3 hidden">
                    <img id="previewImg" src="" alt="Preview" class="max-h-64 rounded-lg">
                    <button type="button" onclick="removeImage()" class="mt-2 text-red-500 text-sm hover:text-red-700">
                        ✕ Hapus Foto
                    </button>
                </div>
                
                <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between items-center">
                    <div class="flex space-x-4 text-sm text-gray-500">
                        <label for="image" class="flex items-center space-x-1 hover:text-teal-600 transition cursor-pointer">
                            <input type="file" id="image" name="image" accept="image/*" class="hidden" onchange="previewImage(event)">
                            🖼️
                            <span class="hidden sm:inline">Foto</span>
                        </label>
                    </div>
                    <button type="submit" class="bg-teal-600 text-white py-1.5 px-4 rounded-lg text-sm font-semibold hover:bg-teal-700 transition shadow-md">
                        Kirim
                    </button>
                </div>
            </form>

  
            @foreach ($posts as $post)
                @include('componentsUser.post-card', ['post' => $post])
            @endforeach
        </div>

          
            <aside class="hidden lg:block w-1/3 space-y-6 sticky top-20 self-start max-h-screen overflow-y-auto ml-9">
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

    {{-- MODAL LAPORAN POSTINGAN --}}
    @include('componentsUser.user-report-modal')

@endsection

@push('scripts')
<script>
    // Preview image before upload
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    // Remove image preview
    function removeImage() {
        document.getElementById('image').value = '';
        document.getElementById('imagePreview').classList.add('hidden');
        document.getElementById('previewImg').src = '';
    }

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
