<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityMember;
use Illuminate\Http\Request;

class CommunityMemberController extends Controller
{
    // JOIN KOMUNITAS
    public function join($id)
    {
        $community = Community::findOrFail($id);
        $user      = auth()->user();

        // kalau sudah join, nggak usah dobel
        $already = CommunityMember::where('community_id', $community->id)
                                  ->where('user_id', $user->id)
                                  ->exists();

        if (!$already) {
            CommunityMember::create([
                'community_id' => $community->id,
                'user_id'      => $user->id,
            ]);

            // update jumlah anggota
            $community->increment('members_count');
        }

        return back()->with('success', 'Kamu berhasil bergabung di komunitas ini.');
    }

    // KELUAR KOMUNITAS
    public function leave($id)
    {
        $community = Community::findOrFail($id);
        $user      = auth()->user();

        // pemilik komunitas tidak boleh keluar
        if ($community->owner_id == $user->id) {
            return back()->with('error', 'Pemilik komunitas tidak dapat keluar dari komunitasnya sendiri.');
        }

        $member = CommunityMember::where('community_id', $community->id)
                                 ->where('user_id', $user->id)
                                 ->first();

        if ($member) {
            $member->delete();
            $community->decrement('members_count');
        }

        return back()->with('success', 'Kamu keluar dari komunitas ini.');
    }
}
