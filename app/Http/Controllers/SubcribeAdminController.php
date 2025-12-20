<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe;
use Carbon\Carbon;

class SubcribeAdminController extends Controller
{
    public function reportsSubscribeIndex()
    {
        $subscribe = Subscribe::all();

        // Revenue bulan ini (HANYA yang PAID)
        $currentMonthRevenue = Subscribe::where('status', 'paid')
            ->whereMonth('start_date', now()->month)
            ->whereYear('start_date', now()->year)
            ->sum('price');

        // Revenue bulan lalu
        $lastMonthRevenue = Subscribe::where('status', 'paid')
            ->whereMonth('start_date', now()->subMonth()->month)
            ->whereYear('start_date', now()->subMonth()->year)
            ->sum('price');

        // Growth (%)
        $growth = 0;
        if ($lastMonthRevenue > 0) {
            $growth = (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        }

        // Total pelanggan aktif (paid & belum expired)
        $totalActiveSubscribers = Subscribe::where('status', 'paid')
            ->whereDate('end_date', '>=', now())
            ->count();

        // Pelanggan baru bulan ini
        $newSubscribersThisMonth = Subscribe::where('status', 'paid')
            ->whereMonth('start_date', now()->month)
            ->whereYear('start_date', now()->year)
            ->count();

        return view('admin.subscribe', compact(
            'subscribe',
            'currentMonthRevenue',
            'growth',
            'totalActiveSubscribers',
            'newSubscribersThisMonth'
        ));
    }

    public function destroy($id)
    {
        $subscribe = Subscribe::findOrFail($id);
        $subscribe->delete();

        return redirect()->route('admin.subscribe');
    }

    public function edit($id)
    {
        $subscribe = Subscribe::findOrFail($id);
        return view('componentsAdmin.edit-subscribe-modal', compact('subscribe'));
    }

    public function update(Request $request, $id)
    {
        $subscribe = Subscribe::findOrFail($id);
        $subscribe->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.subscribe');
    }

    public function create()
    {
        return view('componentsAdmin.add-subscribe-modal');
    }

    public function store(Request $request)
    {
        Subscribe::create([
            'id_subscribe' => $request->id_subscribe,
            'useraname' => $request->username,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.subscribe');
    }
}
