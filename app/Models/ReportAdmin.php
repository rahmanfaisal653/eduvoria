<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAdmin extends Model
{
    use HasFactory;
    protected $table = 'report_admin';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type',
        'reported_by',
        'description',
        'priority',
        'content_summary',
    ];
}
