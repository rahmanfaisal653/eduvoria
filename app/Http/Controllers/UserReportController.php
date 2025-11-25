<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportAdmin;
use Illuminate\Support\Facades\Auth;

class UserReportController extends Controller
{
    public function store(Request $request)
    {

        if (Auth::check()) {
            $pelapor = Auth::user()->name; // Ambil nama user
            // Atau gunakan username: Auth::user()->username;
        } else {
            $pelapor = 'Guest (Pengunjung)'; // Default jika tidak login
        }

        $filePath = null; // Default path
        if ($request->hasFile('foto')) {
            // Simpan file ke storage/app/public/reports
            // 'public' adalah disk name yang harus di-link ke folder public
            $filePath = $request->file('foto')->store('reports', 'public');
            // Contoh path: 'reports/namafileunik.jpg'
        }

        ReportAdmin::create([
            'type' => $request->type,
            'content_summary' => $request->content_summary,
            'description' => $request->description,
            
            // Masukkan variabel pelapor yang sudah kita amankan di atas
            'reported_by' => $pelapor, 
            'priority' => 'Medium',
            'foto' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Laporan terkirim!');
    }
}
