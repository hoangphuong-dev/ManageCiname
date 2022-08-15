<?php

namespace App\Repositories;

use App\Models\Bill;

class AdminAnalysisRepository
{
    public function analysisByCinema($request, $label, $adminId)
    {
        $result = Bill::query()
            ->where('status', BiLL::PAYMENTED)
            ->where('cinema_id', $adminId)->count();

        dd($result);
    }
}
