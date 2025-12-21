<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Eduvoria')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
    @stack('scripts')
</head>
<body class="bg-gray-50 min-h-screen">


   <header class="w-full border-b border-gray-100 bg-white shadow-sm">
  <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
   
    <div class="flex items-center">
      <a href="{{ route('homepage') }}" class="text-2xl font-extrabold text-teal-600 hover:text-teal-700 transition">Eduvoria</a>
    </div>

    <nav class="hidden md:flex space-x-6 text-sm">
      @php
 
        $active = 'font-semibold text-teal-600 border-b-2 border-teal-600 pb-1';
        $base   = 'text-gray-500 hover:text-teal-600';
      @endphp

     <a href="{{ route('homepage') }}"
         class="{{ request()->routeIs('homepage') ? $active : $base }}">
         Beranda
      </a>

      <a href="{{ route('komunitas.index') }}"
      class="{{ request()->routeIs('komunitas.*') ? $active : $base }}">
       Komunitas
      </a>

       <a href="{{ route('kalender.index') }}"
       class="{{ request()->routeIs('kalender.*') ? $active : $base }}">
       Kalender Acara
       </a>
    </nav>

    <form action="{{ route('search') }}" method="GET" class="relative hidden md:block w-96 ml-12">
      <input
        type="text"
        name="query"
        placeholder="Cari postingan atau pengguna"
        class="w-full rounded-full border border-gray-300 bg-gray-50 py-2 pl-4 pr-10 text-sm focus:border-cyan-500 focus:ring-cyan-500"
        required
      />
      <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-teal-600">
        🔍
      </button>
    </form>

    <div class="flex items-center space-x-4">
    @auth
        @if(!auth()->user()->isSubscribed())
            <button id="open-subscribe-modal"
                class="group relative inline-flex items-center justify-center px-5 py-2 overflow-hidden font-bold text-white transition-all duration-300 bg-cyan-500 rounded-full hover:bg-cyan-600 shadow-[0_4px_14px_0_rgba(6,182,212,0.39)] hover:shadow-cyan-500/50">
                <span class="relative text-sm">Subscribe</span>
            </button>
        @else
            <div class="inline-flex items-center space-x-2 bg-gradient-to-r from-cyan-50 to-white px-4 py-1.5 rounded-full border border-cyan-100 shadow-sm">
                <div class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                </div>
                <span class="text-cyan-700 text-xs font-extrabold uppercase tracking-widest">Eduvoria Pro</span>
            </div>
        @endif
    @endauth

      <div class="relative">
        <button
          id="profile-menu-button"
          class="h-10 w-10 rounded-full ring-2 ring-transparent hover:ring-teal-500 transition duration-150 focus:outline-none overflow-hidden"
          aria-expanded="false"
          aria-haspopup="true">
          @auth
            @if(Auth::user()->profile_picture)
              <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
            @else
              <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=F28A25&color=fff&size=40" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
            @endif
          @else
            <div class="bg-gray-300 w-full h-full"></div>
          @endauth
        </button>

        <div
          id="profile-menu"
          class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden z-50"
          role="menu"
          aria-orientation="vertical"
          aria-labelledby="profile-menu-button"
          tabindex="-1">
          <div class="py-1" role="none">
            <a href="{{route('profile')}}"
              class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 font-semibold"
              role="menuitem" tabindex="-1">👤 Profile</a>
            <div class="border-t border-gray-100 my-1" role="separator"></div>
            <a href="{{route('bookmark')}}"
              class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700"
              role="menuitem" tabindex="-1">🔖 Bookmark</a>
            <a href="{{ route('notifikasi') }}"
              class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700"
              role="menuitem" tabindex="-1">🔔 Notifikasi @isset($unreadNotifications)
              @if($unreadNotifications > 0)
              <span class="ml-auto inline-flex items-center justify-center text-xs font-semibold
                   bg-rose-100 text-rose-700 rounded-full px-2 py-0.5">
              {{ $unreadNotifications }}</span>
             @endif
             @endisset
             </a>

            <a href="{{ route('statistik') }}"
              class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700"
              role="menuitem" tabindex="-1">📈 Statistik</a>
            <a href="settings.html"
              class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700"
              role="menuitem" tabindex="-1">⚙️ Settings</a>
            <div class="border-t border-gray-100 my-1" role="separator"></div>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 text-left"
                role="menuitem" tabindex="-1">🚪 Logout</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>


    <!-- KONTEN UTAMA  -->
    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        @yield('content')
    </main>
    <!-- End Main Content -->

    <!-- FOOTER -->
    <footer class="bg-gradient-to-r from-teal-600 to-cyan-700 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-6 lg:grid-cols-8">
                <div class="col-span-2 md:col-span-3 lg:col-span-3">
                    <p class="text-sm">
                        Energetic Social adalah aplikasi media sosial yang dikembangkan dengan visi untuk menghubungkan kita semua.
                    </p>
                </div>
                <div class="space-y-2 text-sm">
                    <h4 class="font-semibold mb-2">Jelajahi</h4>
                    <a href="#" class="block text-teal-200 hover:text-white">Beranda</a>
                    <a href="#" class="block text-teal-200 hover:text-white">Aplikasi Mobile</a>
                    <a href="#" class="block text-teal-200 hover:text-white">Pasar</a>
                </div>
                <div class="space-y-2 text-sm">
                    <h4 class="font-semibold mb-2">Komunitas</h4>
                    <a href="#" class="block text-teal-200 hover:text-white">Ketentuan</a>
                    <a href="#" class="block text-teal-200 hover:text-white">Anggota</a>
                    <a href="#" class="block text-teal-200 hover:text-white">Pengembang</a>
                </div>
                <div class="space-y-2 text-sm">
                    <h4 class="font-semibold mb-2">Dukungan</h4>
                    <a href="#" class="block text-teal-200 hover:text-white">FAQ</a>
                    <a href="#" class="block text-teal-200 hover:text-white">Bantuan</a>
                    <a href="#" class="block text-teal-200 hover:text-white">Kebijakan</a>
                </div>
                <div class="space-y-2 text-sm">
                    <h4 class="font-semibold mb-2">Hukum</h4>
                    <a href="#" class="block text-teal-200 hover:text-white">Ketentuan Layanan</a>
                    <a href="#" class="block text-teal-200 hover:text-white">Kebijakan Privasi</a>
                </div>
            </div>
            <div class="mt-10 border-t border-teal-500 pt-4 text-xs text-teal-100">
                Made with <span class="font-semibold text-white">Eduvoria</span>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <!-- MODAL POP-UP (Harus ada di layout dasar karena bisa dipicu dari mana saja) -->

    <!-- Modal Subscribe -->
    @include('componentsUser.subscribe-modal')

    <!-- Modal Report -->
    <div id="report-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-sm mx-4 transform transition-all duration-300">
            <div class="text-center mb-4">
                <h3 class="text-2xl font-bold text-red-600 mb-1">Laporkan Konten 🚨</h3>
                <p class="text-sm text-gray-600">Bantu kami menjaga komunitas tetap aman.</p>
            </div>
            <form id="report-form" class="space-y-4">
                <div>
                    <label for="pelanggaran-type" class="block text-sm font-medium text-gray-700">Jenis Pelanggaran:</label>
                    <select id="pelanggaran-type" required class="mt-1 w-full rounded-lg border border-gray-300 py-2 px-3 text-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="" disabled selected>Pilih salah satu...</option>
                        <option value="spam">Spam / Promosi Ilegal</option>
                        <option value="kebencian">Ujaran Kebencian / SARA</option>
                        <option value="kekerasan">Konten Kekerasan / Mengganggu</option>
                        <option value="privasi">Pelanggaran Privasi</option>
                        <option value="lain">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Tambahan (Opsional):</label>
                    <textarea id="deskripsi" rows="3" placeholder="Jelaskan mengapa postingan ini melanggar..." class="mt-1 w-full rounded-lg border border-gray-300 p-3 text-sm focus:border-teal-500 focus:ring-teal-500"></textarea>
                </div>
                <input type="hidden" id="reported-post-id" value="">
                <div class="flex justify-between space-x-3 pt-2">
                    <button type="button" id="cancel-report-button" class="flex-1 py-2 rounded-lg text-gray-600 border border-gray-300 hover:bg-gray-100 transition">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 py-2 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elemen Dropdown Profil
            const profileButton = document.getElementById('profile-menu-button');
            const profileMenu = document.getElementById('profile-menu');

            // FUNGSI 1: KONTROL DROPDOWN PROFIL
            profileButton.addEventListener('click', function() {
                const isExpanded = profileButton.getAttribute('aria-expanded') === 'true';
                profileMenu.classList.toggle('hidden');
                profileButton.setAttribute('aria-expanded', !isExpanded);
            });
            document.addEventListener('click', function(event) {
                if (!profileMenu.contains(event.target) && !profileButton.contains(event.target)) {
                    if (!profileMenu.classList.contains('hidden')) {
                        profileMenu.classList.add('hidden');
                        profileButton.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // Tombol pemicu di layout utama (Hanya perlu dicari sekali)
        const openModalTrigger = document.getElementById('open-subscribe-modal'); 

        // Fungsi Buka Modal (Mencari elemen modal secara real-time untuk menghindari error 'null')
        const openModal = () => {
            const modal = document.getElementById('subscribe-modal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        };
        
        // Fungsi Tutup Modal (Mencari elemen modal secara real-time)
        const closeModal = () => {
            const modal = document.getElementById('subscribe-modal');
            if (modal) modal.classList.add('hidden');
        };

        // --- Event Listeners ---
        
        // A. Pemicu Buka Modal (Tombol 'Subscribe' di Layout)
        if (openModalTrigger) {
            openModalTrigger.addEventListener('click', openModal);
        }

        // B. Tombol "Lain kali" (Close Button)
        const closeModalButton = document.getElementById('close-modal-button');
        if (closeModalButton) {
            closeModalButton.addEventListener('click', closeModal);
        }

        // C. Klik di Luar Modal (Overlay Close)
        // Listener dipasang di body untuk menangkap klik di luar kotak modal
        document.body.addEventListener('click', function (e) {
            const modal = document.getElementById('subscribe-modal');
            
            // Cek apakah klik terjadi di luar div putih modal dan di atas div utama (#subscribe-modal)
            if (modal && e.target === modal) {
                closeModal();
            }
        });
    });
    </script>

    
    <!-- Memungkinkan halaman lain menambahkan script tambahan -->
    @stack('scripts')
</body>
</html>
