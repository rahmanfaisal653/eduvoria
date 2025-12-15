@extends('layouts.app')

@section('title', 'Hasil Pencarian - ' . $query)

@section('content')
<div class="container mx-auto px-4">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Hasil Pencarian: "{{ $query }}"</h1>
        <p class="text-gray-600 mt-2">
            Ditemukan {{ $users->count() }} pengguna dan {{ $posts->count() }} postingan
        </p>
    </div>

    <div class="flex gap-8">
        <!-- Main Content -->
        <div class="w-full lg:w-2/3 space-y-6">
            <!-- Users Section -->
            @if($users->count() > 0)
                <div class="bg-white rounded-xl shadow-lg p-5">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">👤 Pengguna</h2>
                    <div class="space-y-3">
                        @foreach($users as $user)
                            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                                <a href="{{ route('profile.show', $user->id) }}" class="flex items-center space-x-3 flex-grow">
                                    @if($user->profile_picture)
                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                             alt="{{ $user->name }}" 
                                             class="h-12 w-12 rounded-full object-cover">
                                    @else
                                        <div class="h-12 w-12 rounded-full bg-teal-500 flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-800 hover:text-teal-600">{{ $user->name }}</p>
                                        @if($user->bio)
                                            <p class="text-sm text-gray-500 line-clamp-1">{{ $user->bio }}</p>
                                        @endif
                                        <p class="text-xs text-gray-400">{{ $user->followers_count }} Pengikut</p>
                                    </div>
                                </a>
                                
                                @if(Auth::id() != $user->id)
                                    <form action="{{ route('follow.toggle', $user->id) }}" method="POST">
                                        @csrf
                                        @if(Auth::user()->isFollowing($user->id))
                                            <button type="submit" class="bg-gray-300 text-gray-700 py-1.5 px-4 rounded-full text-xs font-semibold hover:bg-gray-400 transition">
                                                Diikuti ✓
                                            </button>
                                        @else
                                            <button type="submit" class="bg-teal-600 text-white py-1.5 px-4 rounded-full text-xs font-semibold hover:bg-teal-700 transition">
                                                + Ikuti
                                            </button>
                                        @endif
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Posts Section -->
            @if($posts->count() > 0)
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">📝 Postingan</h2>
                    @foreach($posts as $post)
                        @include('componentsUser.post-card', ['post' => $post])
                    @endforeach
                </div>
            @endif

            <!-- No Results -->
            @if($users->count() == 0 && $posts->count() == 0)
                <div class="bg-white rounded-xl shadow-lg p-10 text-center">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak ada hasil ditemukan</h3>
                    <p class="text-gray-600">Coba gunakan kata kunci yang berbeda</p>
                    <a href="{{ route('homepage') }}" class="inline-block mt-4 bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700">
                        Kembali ke Beranda
                    </a>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <aside class="hidden lg:block w-1/3">
            <div class="bg-white rounded-xl shadow-lg p-5 sticky top-20">
                <h3 class="text-lg font-bold text-gray-800 mb-4">💡 Tips Pencarian</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li>✓ Gunakan kata kunci spesifik</li>
                    <li>✓ Cari berdasarkan nama pengguna</li>
                    <li>✓ Cari topik atau hashtag</li>
                    <li>✓ Cari konten postingan</li>
                </ul>
            </div>
        </aside>
    </div>
</div>

{{-- MODAL LAPORAN POSTINGAN --}}
@include('componentsUser.user-report-modal')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const reportModal = document.getElementById('report-modal');
        const reportedPostIdInput = document.getElementById('reported-post-id');
        
        function openReportModal(postId) {
            if(reportModal) {
                if (reportedPostIdInput) reportedPostIdInput.value = postId; 
                reportModal.classList.remove('hidden');
            }
        }

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
        
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.report-toggle-btn') && !event.target.closest('.report-menu-content')) {
                closeAllReportMenus();
            }
        });

        allMenus.forEach(menu => {
            const reportLink = menu.querySelector('a');
            reportLink.addEventListener('click', function(event) {
                event.preventDefault();
                closeAllReportMenus(); 
                const postId = menu.id; 
                openReportModal(postId);
            });
        });
    });
</script>
@endpush
