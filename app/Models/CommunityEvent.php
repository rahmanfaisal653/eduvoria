<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_id',
        'user_id',
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'location',
    ];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function attendees()
{
    return $this->belongsToMany(User::class, 'community_event_user')
                ->withTimestamps();
}

}
