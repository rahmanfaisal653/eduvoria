<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;

    protected $table = 'subscribes';
    protected $primaryKey = 'id_subscribe';
    protected $fillable = [
        'username',
        'start_date',
        'end_date',
        'status'
    ];

    // Relationship: Subscribe has many Users
    public function users()
    {
        return $this->hasMany(User::class, 'id_subscribe', 'id_subscribe');
    }
}
