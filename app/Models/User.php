<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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

    // Relationship: User has many reports
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // Relationship: User has one Subscribe
    public function subscribe()
    {
        return $this->hasOne(Subscribe::class);
    }
}
