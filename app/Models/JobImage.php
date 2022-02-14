<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class JobImage extends Model
{
    use HasFactory;

    protected $table = 'job_images';

    protected $fillable = [
        'id',
        'job_id',
        'name',
        'path',
    ];

    /**
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        return $this->path ? Storage::url($this->path) : null;
    }

    public function getImagesUrlAttribute()
    {
        // return array_map();
    }
}
