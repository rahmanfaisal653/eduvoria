<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    // kolom yang boleh diisi mass assignment
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'owner_id',
        'members_count',
        'profile_image',
        'background_image',
    ];
}
