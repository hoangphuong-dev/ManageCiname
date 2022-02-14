<?php

namespace App\Repositories;

use App\Models\NotificationRead;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class NotificationReadRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return NotificationRead::class;
    }

    public function markRead($id)
    {

    }
}
