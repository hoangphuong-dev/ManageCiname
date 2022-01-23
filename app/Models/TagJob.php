<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagJob extends Model
{
    use HasFactory;

    protected $table = 'tag_jobs';

    protected $fillable = [
        'id',
        'tag_id',
        'job_id',
    ];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
