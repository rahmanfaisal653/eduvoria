<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityEvent;
use Illuminate\Http\Request;

class CommunityEventController extends Controller
{
    // HALAMAN GLOBAL KALENDER ACARA
    public function index()
    {
        // Untuk sintaks dasar: ambil semua dulu.
        // Nanti kalau sudah ada sistem "gabung komunitas",
        // bisa difilter by user_id atau membership.
        $events = CommunityEvent::orderBy('event_date', 'asc')
                    ->orderBy('start_time', 'asc')
                    ->get();

        return view('users.kalender.index', compact('events'));
    }

    // SIMPAN ACARA BARU DARI HALAMAN DETAIL KOMUNITAS
    public function store(Request $request, $communityId)
    {
        $community = Community::findOrFail($communityId);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date'  => 'required|date',
            'start_time'  => 'nullable',
            'end_time'    => 'nullable',
            'location'    => 'nullable|string|max:255',
        ]);

        $data['community_id'] = $community->id;
        $data['user_id']      = auth()->id() ?? null;

        CommunityEvent::create($data);

        return redirect()
            ->route('komunitas.show', $community->id)
            ->with('success', 'Acara berhasil ditambahkan.');
    }

    // FORM EDIT ACARA
    public function edit($communityId, $id)
    {
        $community = Community::findOrFail($communityId);
        $event = CommunityEvent::where('community_id', $communityId)->findOrFail($id);

        return view('users.komunitas.edit_event', compact('community', 'event'));
    }

    // UPDATE ACARA
    public function update(Request $request, $communityId, $id)
    {
        $community = Community::findOrFail($communityId);
        $event = CommunityEvent::where('community_id', $communityId)->findOrFail($id);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date'  => 'required|date',
            'start_time'  => 'nullable',
            'end_time'    => 'nullable',
            'location'    => 'nullable|string|max:255',
        ]);

        $event->update($data);

        return redirect()
            ->route('komunitas.show', $community->id)
            ->with('success', 'Acara berhasil diperbarui.');
    }

    // HAPUS ACARA
    public function destroy($communityId, $id)
    {
        $community = Community::findOrFail($communityId);
        $event = CommunityEvent::where('community_id', $communityId)->findOrFail($id);

        $event->delete();

        return redirect()
            ->route('komunitas.show', $community->id)
            ->with('success', 'Acara berhasil dihapus.');
    }
}
