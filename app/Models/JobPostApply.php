<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPostApply extends Model
{
    use HasFactory;

    public const JOB_CURRENT_STATUS = 0;
    public const JOB_REJECT_STATUS = 1;
    public const JOB_DONE_STATUS = 2;
    public const JOB_UN_PROGRESS_STATUS = 3;

    protected $table = 'job_post_applies';

    protected $guarded = [];

    protected $casts = [
        'created_at'  => 'date:Y/m/d H:i',
        'updated_at' => 'date:Y/m/d H:i',
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
