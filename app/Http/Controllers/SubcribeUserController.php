<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe; // Pastikan Model ini benar
use Illuminate\Support\Facades\Auth;

class SubcribeUserController extends Controller
{
    public function store(Request $request)
    {
        // 1. Definisikan Variabel yang Dibutuhkan
        $user = Auth::user(); 
        $startDate = now();
        $endDate = now()->addDays(30); // Contoh: Langganan 30 hari

        // 2. Simpan Langganan Baru ke Database
        // Menggunakan data yang Anda berikan
        Subscribe::create([
            'user_id' => $user->id,
            'username' => $user->name, 
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active', // Langganan langsung aktif
        ]);

        // 3. Redirect ke halaman tampilan setelah sukses
        return redirect()->back()->with('success', 'Langganan Anda berhasil diaktifkan!');
    }
}