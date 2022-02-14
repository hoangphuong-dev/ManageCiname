<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobProcess extends Model
{
    use HasFactory;

    protected $table = 'job_processes';

    protected $fillable = [
        'id',
        'job_id',
        'content',
        'order',
    ];

    protected $casts = [
        'order' => 'integer'
    ];


}
