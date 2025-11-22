<div id="subscribe-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center transition-opacity">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4 transform transition-all duration-300">
        
        <div class="text-center">
            <div class="mx-auto h-12 w-12 rounded-full bg-teal-100 flex items-center justify-center text-3xl mb-4">✨</div>
            <h3 class="text-2xl font-extrabold text-teal-600 mb-2">Upgrade Komunitas Anda!</h3>
            <p class="text-gray-600 mb-6">
                Untuk memiliki keanggotaan penuh dan membuat Room Komunitas baru, Anda perlu berlangganan ke paket Premium Connectify.
            </p>
            
            <div class="space-y-3 mb-6">
                {{-- Daftar Fitur --}}
                <p class="text-sm font-medium text-gray-800 flex items-center justify-center space-x-2">
                    <span class="text-green-500">✔</span> <span>Bebas Buat Room Komunitas (Fitur Utama)</span>
                </p>
                {{-- (Tambahkan fitur lainnya di sini) --}}
            </div>
            
            {{-- FORM SUBMISSION LANGGANAN INSTAN --}}
            <form action="{{ route('user.subscribe.store') }}" method="POST">
                @csrf
                
                {{-- Data yang dikirim --}}
                <input type="hidden" name="plan_type" value="premium_connectify">
                <input type="hidden" name="price" value="59000">

                <button type="submit" class="w-full py-3 bg-cyan-600 text-white font-bold rounded-lg hover:bg-cyan-700 transition shadow-lg">
                    Berlangganan Sekarang (Rp 59.000 / Bulan)
                </button>
            </form>
            
            <button id="close-modal-button" class="mt-3 w-full py-2 text-sm text-gray-500 hover:text-gray-700">
                Lain kali
            </button>
        </div>

    </div>
</div>

