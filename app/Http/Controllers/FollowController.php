<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Notification;
use App\Models\User;

class FollowController extends Controller
{
    public function toggle(User $user)
    {
        $me = auth()->id();

        if ($user->id == $me) return back();

        $exists = Follow::where('follower_id', $me)
            ->where('following_id', $user->id)
            ->exists();

        if ($exists) {
            Follow::where('follower_id', $me)->where('following_id', $user->id)->delete();
        } else {
            Follow::create(['follower_id' => $me, 'following_id' => $user->id]);

            Notification::create([
                'user_id' => $user->id,
                'from_user_id' => $me,
                'type' => 'follow',
                'reference_id' => null,
            ]);
        }

        return back();
    }
}
