<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<div class="min-h-screen bg-[#F8FAFC] py-12 px-4">
    <div class="max-w-md mx-auto bg-white shadow-sm border border-gray-100 rounded-[2rem] overflow-hidden">
        
        <div class="p-8 pb-0">
            <h2 class="text-2xl font-extrabold text-gray-800 mb-2">Konfirmasi Pembayaran</h2>
            <p class="text-gray-500 text-sm">Selesaikan pembayaran untuk menikmati fitur premium Eduvoria.</p>
        </div>

        <div class="p-8">
            <div class="mb-8 p-6 bg-[#F0F9FA] rounded-[1.5rem] border border-cyan-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-bold text-cyan-700 uppercase tracking-wider">Total Pembayaran</p>
                    <p class="text-2xl font-black text-cyan-600">Rp {{ number_format($pending['price'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-white p-3 rounded-2xl shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04 Pelajari" />
                    </svg>
                </div>
            </div>

            <form action="{{ route('users.subscribe.confirm') }}" method="POST">
                @csrf
                <p class="text-sm font-bold text-gray-700 mb-4 ml-1">Pilih Metode Pembayaran</p>
                
            <div class="space-y-4">
                <label class="group relative flex items-center justify-between p-4 border-2 border-gray-50 rounded-[1.25rem] cursor-pointer hover:border-cyan-400 hover:bg-cyan-50/30 transition-all duration-300">
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" value="credit_card" class="hidden peer" required checked>
                        <div class="w-6 h-6 border-2 border-gray-300 rounded-full peer-checked:border-cyan-500 peer-checked:bg-cyan-500 flex items-center justify-center transition-all">
                            <div class="w-2 h-2 bg-white rounded-full"></div>
                        </div>
                        <span class="ml-4 font-semibold text-gray-600 group-hover:text-cyan-700 transition-colors">Kartu Kredit</span>
                    </div>
                    <div class="flex space-x-2 items-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d6/Visa_2021.svg" alt="Visa" class="h-4 w-auto object-contain">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" class="h-6 w-auto object-contain">
                    </div>
                </label>

                <label class="group relative flex items-center justify-between p-4 border-2 border-gray-50 rounded-[1.25rem] cursor-pointer hover:border-cyan-400 hover:bg-cyan-50/30 transition-all duration-300">
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" value="bank_transfer" class="hidden peer">
                        <div class="w-6 h-6 border-2 border-gray-300 rounded-full peer-checked:border-cyan-500 peer-checked:bg-cyan-500 flex items-center justify-center transition-all">
                            <div class="w-2 h-2 bg-white rounded-full"></div>
                        </div>
                        <span class="ml-4 font-semibold text-gray-600 group-hover:text-cyan-700 transition-colors">Transfer Bank</span>
                    </div>
                    <div class="flex space-x-3 items-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/1200px-Bank_Central_Asia.svg.png" alt="BCA" class="h-4 w-auto object-contain">
                    </div>
                </label>

                <label class="group relative flex items-center justify-between p-4 border-2 border-gray-50 rounded-[1.25rem] cursor-pointer hover:border-cyan-400 hover:bg-cyan-50/30 transition-all duration-300">
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" value="e_wallet" class="hidden peer">
                        <div class="w-6 h-6 border-2 border-gray-300 rounded-full peer-checked:border-cyan-500 peer-checked:bg-cyan-500 flex items-center justify-center transition-all">
                            <div class="w-2 h-2 bg-white rounded-full"></div>
                        </div>
                        <span class="ml-4 font-semibold text-gray-600 group-hover:text-cyan-700 transition-colors">E-Wallet</span>
                    </div>
                    <div class="flex space-x-3 items-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/1200px-Gopay_logo.svg.png" alt="GOPAY" class="h-3.5 w-auto object-contain">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/1200px-Logo_ovo_purple.svg.png" alt="OVO" class="h-3.5 w-auto object-contain">
                    </div>
                </label>
            </div>

                <button type="submit" class="w-full mt-10 py-4 bg-[#00A9B5] text-white font-extrabold rounded-2xl hover:bg-[#008f99] shadow-lg shadow-cyan-200 transition-all duration-300 transform hover:-translate-y-1">
                    Bayar & Berlangganan
                </button>
                
                <p class="text-center mt-6 text-xs text-gray-400">
                    Transaksi aman & terenkripsi oleh Eduvoria Payment System
                </p>
            </form>
        </div>
    </div>
</div>