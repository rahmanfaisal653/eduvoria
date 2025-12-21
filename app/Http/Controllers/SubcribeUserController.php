<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe;
use Illuminate\Support\Facades\Auth;

class SubcribeUserController extends Controller // Perbaikan typo: Subcribe -> Subscribe
{
    /**
     * Tahap 1: Tangkap data paket dari Landing Page/Pricing.
     */
    public function prepare(Request $request)
    {
        // Validasi input agar tidak ada data kosong masuk ke session
        $request->validate([
            'plan_type' => 'required',
            'price' => 'required|numeric',
        ]);

        // Simpan data ke session
        session([
            'pending_sub' => [
                'plan_type' => $request->plan_type,
                'price' => $request->price,
            ]
        ]);

        return redirect()->route('users.subscribe.checkout');
    }

    /**
     * Tahap 2: Tampilkan halaman pilihan pembayaran.
     */
    public function checkout()
    {
        $pending = session('pending_sub');

        // Jika user mencoba akses langsung tanpa klik tombol langganan
        if (!$pending) {
            return redirect('/')->with('error', 'Silakan pilih paket terlebih dahulu.');
        }

        return view('users.subscribe.checkout', compact('pending'));
    }

    /**
     * Tahap 3: Simpan ke database setelah user memilih metode pembayaran.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $pending = session('pending_sub');

        // Cek apakah data paket masih ada di session
        if (!$pending) {
            // Arahkan langsung ke URL landing page (biasanya '/')
            return redirect('homepage')->with('error', 'Sesi Anda telah berakhir.');
        }

        // Validasi input metode pembayaran
        $request->validate([
            'payment_method' => 'required|in:credit_card,bank_transfer,e_wallet'
        ]);

        // Simpan ke Database
        Subscribe::create([
            'user_id' => $user->id,
            'username' => $user->name, // Pastikan kolom di DB adalah 'username' bukan 'useraname'
            'start_date' => now(),
            'end_date' => now()->addDays(30), 
            'status' => 'pending', 
            'price' => $pending['price'],
            'payment_method' => $request->payment_method,
        ]);

        // Hapus session agar tidak bisa di-refresh untuk duplikat data
        session()->forget('pending_sub');

        // Pastikan route 'dashboard' sudah terdaftar di web.php
        return redirect()->route('homepage');
    }
}