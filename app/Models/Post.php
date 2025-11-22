<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'image',
        'likes_count'
    ];

    // Relationship: Post belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Post has many Bookmarks
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}
