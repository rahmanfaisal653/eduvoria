<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityEvent;
use App\Models\CommunityMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// ====== DITAMBAH ======
use Illuminate\Support\Facades\DB;

class CommunityEventController extends Controller
{
    public function __construct()
    {
        // Halaman kalender acara harus login
        $this->middleware('auth');
    }

    /**
     * HALAMAN /kalender-acara
     * Menampilkan semua acara dari komunitas yang:
     * - dimiliki user, atau
     * - user menjadi anggota di komunitas tsb.
     */
    public function index()
    {
        $user = Auth::user();

        // komunitas yang user miliki (owner)
        $ownedCommunityIds = Community::where('owner_id', $user->id)->pluck('id')->toArray();

        // komunitas yang user ikuti (member)
        $memberCommunityIds = CommunityMember::where('user_id', $user->id)
            ->pluck('community_id')
            ->toArray();

        // gabungkan semua id komunitas yang relevan
        $communityIds = array_unique(array_merge($ownedCommunityIds, $memberCommunityIds));

        // ambil semua event dari komunitas-komunitas tsb
        // $events = CommunityEvent::whereIn('community_id', $communityIds)
        //     ->orderBy('event_date')
        //     ->orderBy('start_time')
        //     ->get();

        // ====== DISESUAIKAN: Kalender pribadi bersifat OPT-IN ======
        // Yang tampil di /kalender-acara hanya event yang user "tambahkan" ke kalender
        // (bukan otomatis dari komunitas).
        // Table pivot: community_event_user (community_event_id, user_id, created_at, updated_at)
        $events = CommunityEvent::whereIn('id', function ($q) use ($user) {
                $q->select('community_event_id')
                  ->from('community_event_user')
                  ->where('user_id', $user->id);
            })
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->get();

        // misal view-nya: resources/views/users/kalender/index.blade.php
        return view('users.kalender.index', compact('events'));
    }

    /**
     * SIMPAN ACARA BARU dari halaman detail komunitas
     * Route: POST /komunitas/{communityId}/events
     */
    public function store(Request $request, $communityId)
    {
        $user = Auth::user();
        $community = Community::findOrFail($communityId);

        // hanya admin atau pemilik komunitas
        $isOwner = ($community->owner_id === $user->id);
        $isAdmin = ($user->role === 'admin');

        if (!$isOwner && !$isAdmin) {
            abort(403, 'Kamu tidak punya akses membuat acara di komunitas ini.');
        }

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date'  => 'required|date',
            'start_time'  => 'nullable',
            'end_time'    => 'nullable',
            'location'    => 'nullable|string|max:255',
        ]);

        $data['community_id'] = $community->id;
        $data['user_id']      = $user->id;   // pembuat acara / admin komunitas

        $event = CommunityEvent::create($data);

        // ====== DITAMBAH (opsional tapi enak): pembuat otomatis masuk kalender pribadinya ======
        // Supaya event yang dibuat owner/admin otomatis muncul di kalender si pembuat.
        // Kalau kamu tidak mau ini, hapus blok ini (tapi kamu bilang jangan hapus apapun,
        // jadi aku taro sebagai tambahan yang aman).
        DB::table('community_event_user')->updateOrInsert(
            [
                'community_event_id' => $event->id,
                'user_id' => $user->id,
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return redirect()
            ->route('komunitas.show', $community->id)
            ->with('success', 'Acara komunitas berhasil dibuat.');
    }

    /**
     * FORM EDIT ACARA
     * Route: GET /komunitas/{communityId}/events/{id}/edit
     */
    public function edit($communityId, $id)
    {
        $community = Community::findOrFail($communityId);
        $event     = CommunityEvent::where('community_id', $communityId)->findOrFail($id);

        $user = Auth::user();
        $isOwner = ($community->owner_id === $user->id);
        $isAdmin = ($user->role === 'admin');

        if (!$isOwner && !$isAdmin) {
            abort(403, 'Kamu tidak punya akses mengedit acara ini.');
        }

        return view('users.komunitas.edit_event', compact('community', 'event'));
    }

    /**
     * UPDATE ACARA
     * Route: PUT /komunitas/{communityId}/events/{id}
     */
    public function update(Request $request, $communityId, $id)
    {
        $community = Community::findOrFail($communityId);
        $event     = CommunityEvent::where('community_id', $communityId)->findOrFail($id);

        $user = Auth::user();
        $isOwner = ($community->owner_id === $user->id);
        $isAdmin = ($user->role === 'admin');

        if (!$isOwner && !$isAdmin) {
            abort(403, 'Kamu tidak punya akses mengupdate acara ini.');
        }

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
            ->with('success', 'Acara komunitas berhasil diperbarui.');
    }

    /**
     * HAPUS ACARA
     * Route: DELETE /komunitas/{communityId}/events/{id}
     */
    public function destroy($communityId, $id)
    {
        $community = Community::findOrFail($communityId);
        $event     = CommunityEvent::where('community_id', $communityId)->findOrFail($id);

        $user = Auth::user();
        $isOwner = ($community->owner_id === $user->id);
        $isAdmin = ($user->role === 'admin');

        if (!$isOwner && !$isAdmin) {
            abort(403, 'Kamu tidak punya akses menghapus acara ini.');
        }

        $event->delete();

        // ====== DITAMBAH: bersihin pivot biar rapih ======
        DB::table('community_event_user')->where('community_event_id', $id)->delete();

        return redirect()
            ->route('komunitas.show', $community->id)
            ->with('success', 'Acara komunitas berhasil dihapus.');
    }

    // ======================================================================
    // DITAMBAH: USER MENAMBAHKAN EVENT KE KALENDER PRIBADI (OPT-IN)
    // Route: POST /komunitas/{communityId}/events/{id}/add-to-calendar
    // ======================================================================
    public function addToCalendar($communityId, $id)
    {
        $user = Auth::user();

        $community = Community::findOrFail($communityId);
        $event = CommunityEvent::where('community_id', $communityId)->findOrFail($id);

        // user harus owner atau member komunitas untuk boleh menambahkan event
        $isOwner = ($community->owner_id === $user->id);
        $isMember = CommunityMember::where('community_id', $communityId)
            ->where('user_id', $user->id)
            ->exists();

        if (!$isOwner && !$isMember) {
            abort(403, 'Kamu harus bergabung komunitas untuk menambahkan acara ini ke kalender.');
        }

        DB::table('community_event_user')->updateOrInsert(
            [
                'community_event_id' => $event->id,
                'user_id' => $user->id,
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return redirect()
            ->back()
            ->with('success', 'Acara ditambahkan ke Kalender Acara kamu.');
    }

    // ======================================================================
    // DITAMBAH: USER MENGHAPUS EVENT DARI KALENDER PRIBADI
    // Route: DELETE /komunitas/{communityId}/events/{id}/remove-from-calendar
    // ======================================================================
    public function removeFromCalendar($communityId, $id)
    {
        $user = Auth::user();

        $community = Community::findOrFail($communityId);
        $event = CommunityEvent::where('community_id', $communityId)->findOrFail($id);

        DB::table('community_event_user')
            ->where('community_event_id', $event->id)
            ->where('user_id', $user->id)
            ->delete();

        return redirect()
            ->back()
            ->with('success', 'Acara dihapus dari Kalender Acara kamu.');
    }
}
