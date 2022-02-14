<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public const COMMENT_STATUS_SHOW = 1;
    public const COMMENT_STATUS_HIDE = 0;

    protected $table = 'comments';

    protected $fillable = [
        'id',
        'job_id',
        'user_id',
        'content',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->belongsTo(Job::class);
    }
}
