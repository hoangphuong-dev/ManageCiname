<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobFavorite extends Model
{
    use HasFactory;

    protected $table = 'job_favorites';

    protected $fillable = [
        'id',
        'user_id',
        'job_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
