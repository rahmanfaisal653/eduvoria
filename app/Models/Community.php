<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    // kolom yang boleh diisi mass assignment
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'owner_id',
        'members_count',
        'profile_image',
        'background_image',
    ];
     public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function posts()
    {
        return $this->hasMany(CommunityPost::class);
    }

    public function events()
    {
        return $this->hasMany(CommunityEvent::class);
    }

    public function members()
{
    return $this->hasMany(CommunityMember::class);
}

public function isMember($userId)
{
    return $this->members()->where('user_id', $userId)->exists();
}
}
