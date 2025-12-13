<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id', 'from_user_id', 'type', 'reference_id', 'is_read'
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }
}
