<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostAdmin extends Model
{
    use HasFactory;

    protected $table = 'post_admin';
    protected $primaryKey = 'id';
    protected $fillable = [
        'content',
        'author',
        'status',
    ];
}
