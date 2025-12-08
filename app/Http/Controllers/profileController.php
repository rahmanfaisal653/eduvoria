<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class profileController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        
        // Load user posts
        $posts = Post::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('users.profile', compact('user', 'posts'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('users.editProfile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'hobi' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        
        if ($request->hasFile('profile_picture')) {
          
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            $user->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user->name = $request->name;
        $user->bio = $request->bio;
        $user->hobi = $request->hobi;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }
}