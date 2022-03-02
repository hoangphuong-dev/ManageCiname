<?php

namespace App\Exports;

use App\Models\Movie;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MovieExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize
{
    public function collection()
    {
        return Movie::select('name', 'director', 'description', 'trailler', 'movie_length', 'rated')
            ->limit(5)->get();
    }

    public function headings(): array
    {
        return [
            'name',
            'director',
            'description',
            'trailler',
            'movie_length',
            'rated'
        ];
    }
}
