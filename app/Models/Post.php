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
        'likes_count',
        'status'
    ];

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

  
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
