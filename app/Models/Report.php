<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAdmin extends Model
{
    use HasFactory;
    protected $table = 'report';
    protected $primaryKey = 'id_report';
    protected $fillable = [
        'type',
        'reported_by',
        'description',
        'priority',
        'content_summary',
        'foto'
    ];
}
