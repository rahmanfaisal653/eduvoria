<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = 'reports';
    protected $primaryKey = 'id_report';
    protected $fillable = [
        'type',
        'reported_by',
        'description',
        'priority',
        'content_summary',
        'foto'
    ];

    // Relationship: Report belongs to User
    public function user()
    {
        return $this->belongsTo(User::class, 'reported_by', 'id');
    }
}
