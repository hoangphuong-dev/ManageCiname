<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'type',
    ];

    public function tagJobs()
    {
        return $this->hasMany(TagJob::class);
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'tag_jobs');
    }
}
