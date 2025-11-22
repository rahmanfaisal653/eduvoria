<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;

    protected $table = 'subscribe_admin';
    protected $primaryKey = 'id';
    protected $fillable = [
        'username',
        'start_date',
        'end_date',
        'status',
    ];
}
