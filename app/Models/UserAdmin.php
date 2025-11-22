<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdmin extends Model
{
    use HasFactory;
    protected $table = 'user_admin';
    protected $primaryKey = 'id';
    protected $fillable = [
        'email',
        'username',
        'password',
        'status',
    ];
}
