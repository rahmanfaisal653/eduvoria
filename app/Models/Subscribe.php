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
        'id_subscribe',
        'username',
        'start_date',
        'end_date',
        'status',
        'price',
        'payment_method',
    ];

    public function scopeActive($query)
    {
        return $query
            ->where('status', 'paid') 
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }

    public function subscribes()
    {
        return $this->hasMany(Subscribe::class, 'user_id');
    }
}
