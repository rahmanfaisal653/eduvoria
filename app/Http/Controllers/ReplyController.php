<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    // Simpan reply baru
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $reply = new Reply;
        $reply->post_id = $postId;
        $reply->user_id = Auth::id();
        $reply->content = $request['content'];
        $reply->save();

        return redirect()->back()->with('success', 'Balasan berhasil ditambahkan!');
    }

    // Hapus reply
    public function destroy($id)
    {
        $reply = Reply::findOrFail($id);

     
        if ($reply->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus balasan orang lain!');
        }

        $reply->delete();

        return redirect()->back()->with('success', 'Balasan berhasil dihapus!');
    }
}
