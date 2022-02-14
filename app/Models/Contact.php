<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public const CONTACT_STATUS_UNREAD = 0;
    public const CONTACT_STATUS_READ = 1;

    public const CONTACT_TYPE_HOSPITAL = 1;
    public const CONTACT_TYPE_CARETAKER = 2;

    protected $table = 'contacts';


    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusNameAttribute()
    {
        return $this->status === self::CONTACT_STATUS_READ ? 'Readed' : 'New';
    }
}
