<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityMember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommunityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // LIST SEMUA KOMUNITAS
    public function index()
    {
        $communities = Community::latest()->paginate(10);

        return view('users.komunitas.komunitas', compact('communities'));
    }

    // FORM BUAT KOMUNITAS
    public function create()
    {
        $user = auth()->user();

        if (!$user->isAdmin() && !$user->isSubscribed()) {
            return redirect()->route('komunitas.index')
                ->with('error', 'Kamu harus berlangganan terlebih dahulu untuk membuat komunitas.');
        }

        return view('users.komunitas.create');
    }

    // SIMPAN KOMUNITAS BARU
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->isAdmin() && !$user->isSubscribed()) {
            return redirect()->route('komunitas.index')
                ->with('error', 'Kamu harus berlangganan terlebih dahulu untuk membuat komunitas.');
        }

        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'category'         => 'nullable|string|max:255',
            'profile_image'    => 'nullable|image|mimes:jpg,jpeg,png',
            'background_image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $data['slug']           = Str::slug($data['name']);
        $data['owner_id']       = $user->id;    // user pembuat komunitas
        $data['members_count']  = 1;

        // upload memakai storage link
        if ($request->hasFile('profile_image')) {
            $filename = time() . '_' . $request->file('profile_image')->getClientOriginalName();
            $request->file('profile_image')->storeAs('komunitas', $filename, 'public');
            $data['profile_image'] = $filename;
        }

        if ($request->hasFile('background_image')) {
            $filename = time() . '_' . $request->file('background_image')->getClientOriginalName();
            $request->file('background_image')->storeAs('komunitas', $filename, 'public');
            $data['background_image'] = $filename;
        }

        $community = Community::create($data);

        // otomatis masukkan pembuat komunitas sebagai member
        CommunityMember::create([
            'community_id' => $community->id,
            'user_id'      => $user->id
        ]);

        return redirect()->route('komunitas.show', $community->id)
            ->with('success', 'Komunitas berhasil dibuat!');
    }

    // DETAIL KOMUNITAS
    public function show($id)
    {
        $community = Community::findOrFail($id);

        $posts = $community->posts()->latest()->get();
        $events = $community->events()->orderBy('event_date')->get();

        $user = auth()->user(); // boleh null (guest)

        // ============================
        // CEK APAKAH USER MEMBER
        // ============================
        $isMember = false;
        $isOwner  = false;
        $owner = $community->owner; 

    if ($user) {
    $isOwner  = ($community->owner_id === $user->id);

    $isMember = $isOwner || CommunityMember::where('community_id', $community->id)
                                           ->where('user_id', $user->id)
                                           ->exists();
    }

        // ============================
        // AKSES KELOLA HANYA UNTUK OWNER + ADMIN
        // ============================
        $bolehKelola = false;

        if ($user) {
            $bolehKelola =
                ($user->role === 'admin') ||
                ($user->isSubscribed() && $community->owner_id === $user->id);
        }

    return view('users.komunitas.komunitasdiskusi', compact(
    'community',
    'posts',
    'events',
    'bolehKelola',
    'isMember',
    'isOwner',
    'owner'   
       ));
    }

    // FORM EDIT KOMUNITAS
    public function edit($id)
    {
        $community = Community::findOrFail($id);
        $user      = auth()->user();

        if (
            !$user->isAdmin()
            && !($user->isSubscribed() && $community->owner_id === $user->id)
        ) {
            abort(403, 'Kamu tidak punya akses untuk mengedit komunitas ini.');
        }

        return view('users.komunitas.edit', compact('community'));
    }

    // UPDATE KOMUNITAS
    public function update(Request $request, $id)
    {
        $community = Community::findOrFail($id);
        $user      = auth()->user();

        if (
            !$user->isAdmin()
            && !($user->isSubscribed() && $community->owner_id === $user->id)
        ) {
            abort(403, 'Kamu tidak punya akses untuk mengupdate komunitas ini.');
        }

        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'category'         => 'nullable|string|max:255',
            'profile_image'    => 'nullable|image|mimes:jpg,jpeg,png',
            'background_image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('profile_image')) {
            $filename = time() . '_' . $request->file('profile_image')->getClientOriginalName();
            $request->file('profile_image')->storeAs('komunitas', $filename, 'public');
            $data['profile_image'] = $filename;
        }

        if ($request->hasFile('background_image')) {
            $filename = time() . '_' . $request->file('background_image')->getClientOriginalName();
            $request->file('background_image')->storeAs('komunitas', $filename, 'public');
            $data['background_image'] = $filename;
        }

        $community->update($data);

        return redirect()->route('komunitas.show', $community->id)
            ->with('success', 'Komunitas berhasil diperbarui.');
    }

    // HAPUS KOMUNITAS
    public function destroy($id)
    {
        $community = Community::findOrFail($id);
        $user      = auth()->user();

        if (
            !$user->isAdmin()
            && !($user->isSubscribed() && $community->owner_id === $user->id)
        ) {
            abort(403, 'Kamu tidak punya akses untuk menghapus komunitas ini.');
        }

        $community->delete();

        return redirect()->route('komunitas.index')
            ->with('success', 'Komunitas berhasil dihapus.');
    }
}
