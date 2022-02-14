<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;

    public const STATUS_WAITING = 0;
    public const STATUS_PUBLIC = 1;
    public const STATUS_UPDATING = 2;
    public const STATUS_PENDING = 3;

    public const TYPE_WORK_PARTTIME = 0;
    public const TYPE_WORK_FULLTIME = 1;

    protected $table = 'jobs';

    protected $fillable = [
        'id', 'user_id', 'name', 'hospital_name', 'address', 'nearest_station', 'map_station', 'advantages',
        'description', 'wage_min', 'wage_max', 'annual_income_min', 'annual_income_max', 'type_of_work',
        'working_hours', 'holidays', 'number_annual_holidays', 'description', 'occupation', 'certificate',
        'years_experience', 'skills', 'experience_priority', 'benefits', 'comapany_name', 'comapany_establishment',
        'comapany_introduce', 'rate_count', 'rate_average', 'status'
    ];

    protected $casts = [
        'working_hours' => 'array',
        'holidays' => 'array',
        'occupation' => 'array',
        'certificate' => 'array',
        'skills' => 'array',
        'experience_priority' => 'array',
        'benefits' => 'array',
        'created_at'  => 'date:Y/m/d H:i',
        'updated_at' => 'date:Y/m/d H:i',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(JobFavorite::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function applies()
    {
        return $this->hasMany(JobPostApply::class);
    }

    public function processes()
    {
        return $this->hasMany(JobProcess::class)->orderBy('order', 'asc');
    }

    public function jobApplyPendingMany()
    {
        return $this->hasMany(JobApplyStatus::class)->where('status', JobApplyStatus::PENDING);
    }

    public function jobApplyPending()
    {
        return $this->hasOne(JobApplyStatus::class)->where('status', JobApplyStatus::PENDING);
    }

    public function jobApplySuccess()
    {
        return $this->hasMany(JobApplyStatus::class)->where('status', JobApplyStatus::SUCCESS);
    }

    public function jobApplyReject()
    {
        return $this->hasMany(JobApplyStatus::class)->where('status', JobApplyStatus::REJECT);
    }

    public function jobApplyDone()
    {
        return $this->hasMany(JobApplyStatus::class)->whereIn('status', [JobApplyStatus::SUCCESS, JobApplyStatus::REJECT]);
    }

    public function jobApply()
    {
        return $this->hasMany(JobApplyStatus::class);
    }


    public function tagJobs()
    {
        return $this->hasMany(TagJob::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_jobs', 'job_id', 'tag_id');
    }

    /**
     * Job image relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(JobImage::class);
    }

    public function getTypeOfWorkNameAttribute()
    {
        return $this->type_of_work === self::TYPE_WORK_PARTTIME ? 'パートタイム' : '正社員';
    }

    public function getStatusNameAttribute()
    {
        switch ($this->status) {
            case self::STATUS_PUBLIC:
                return '公開中';
            case self::STATUS_WAITING:
                return '承認待ち';
            case self::STATUS_PENDING:
                return '保留';
            case self::STATUS_UPDATING:
                return 'Updating';
            default:
                return 'Unknow';
        }
    }

    public function scopeIsShowApprovalButton()
    {
        return $this->status !== self::STATUS_PUBLIC && $this->status !== self::STATUS_PENDING;
    }

    public function scopeShow($query)
    {
        $query->where('status', '<>', self::STATUS_WAITING);
    }

    public function getAvgFavorableInterview()
    {
        return $this->ratings()->avg('favorable_interview');
    }

    public function getAvgAtmosphereInterview()
    {
        return $this->ratings()->avg('atmosphere_interview');
    }

    public function getToltalAvgRatingAttribute()
    {
        return ($this->getAvgFavorableInterview() + $this->getAvgAtmosphereInterview());
    }
}
