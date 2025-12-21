<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// tambahin import model lain
use App\Models\Post;
use App\Models\Bookmark;
use App\Models\Community;
use App\Models\CommunityEvent;
use App\Models\Subscribe;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'bio',
        'hobi',
        'role',
        'followers_count',
        'following_count',
        'status',
        'id_subscribe',
        'id_report'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationship: User has many Posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Relationship: User has many Bookmarks
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    /* ==================== TAMBAHAN ==================== */

    // komunitas yang dia buat (owner)
    public function ownedCommunities()
    {
        return $this->hasMany(Community::class, 'owner_id');
    }

    // event komunitas yang dia buat (kalau di community_events ada user_id)
    public function communityEvents()
    {
        return $this->hasMany(CommunityEvent::class, 'user_id');
    }

    // relasi ke subscribe berdasarkan username (name)
    public function subscribe()
    {
        // sesuaikan kalau di tabel subscribes kamu pakai kolom lain
        return $this->hasOne(Subscribe::class, 'username', 'name');
    }

    // cek apakah user ini admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // cek apakah user ini sedang aktif subscribe
    public function isSubscribed(): bool
    {
        // Cari data di tabel subscribes yang punya user_id sama dengan user ini
        // dan masuk dalam scope active (status paid & belum expired)
        return \App\Models\Subscribe::active()
            ->where('username', $this->name)
            ->exists();
    }

    public function communityMemberships()
    {
        return $this->hasMany(CommunityMember::class, 'user_id');
    }

    public function isMemberOf($communityId)
    {
        return $this->communityMemberships()->where('community_id', $communityId)->exists();
    }

    // Relasi untuk followers (yang mengikuti user ini)
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
            ->withTimestamps();
    }

    // Relasi untuk following (yang diikuti oleh user ini)
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
            ->withTimestamps();
    }

    // Cek apakah user ini mengikuti user lain
    public function isFollowing($userId)
    {
        return $this->following()->where('following_id', $userId)->exists();
    }

    // Cek apakah user ini diikuti oleh user lain
    public function isFollowedBy($userId)
    {
        return $this->followers()->where('follower_id', $userId)->exists();
    }
}
