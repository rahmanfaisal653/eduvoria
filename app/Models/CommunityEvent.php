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
}
