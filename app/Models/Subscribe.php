<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;

    protected $table = 'subscribes';
    protected $primaryKey = 'id_subscribe';
    public $incrementing = true;
    protected $fillable = [
        'username',
        'start_date',
        'end_date',
        'status'
    ];

    public function scopeActive($query)
    {
        return $query
            ->where('status', 'active') 
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }
}
