<?php

namespace App\Exports;

use App\Models\Movie;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MovieExport implements
    WithHeadings,
    ShouldAutoSize,
    WithMapping

{
    // public function columnFormats(): array
    // {
    //     $movie = Movie::with(['casts'])->first();
    //   
    //     return [
    //         'casts' => 111,
    //         'movie_genres' => 666,
    //         'format_movies' => 1111,
    //     ];
    // }
    // public function query()
    // {
    //     return Movie::query();
    // }


    public function map($row): array
    {
        $movie = Movie::with(['casts'])->first();
        $array_name = array();
        foreach ($movie->casts as $row) {
            $array_name[] = $row->name;
        }
        $cast = implode(',', $array_name);
        return [
            'name'  => $row->name,
            'director'  => $row->director,
            'description'  => $row->description,
            'trailer'  => $row->trailer,
            'movie_length'  => $row->movie_length,
            'rated'  => $row->rated,
            'casts' => $cast

        ];
    }

    public function collection()
    {
        return Movie::select('name', 'director', 'description', 'trailer', 'movie_length', 'rated')
            ->limit(1)
            ->get();
    }


    public function headings(): array
    {
        return [
            'name',
            'director',
            'description',
            'trailer',
            'movie_length',
            'rated',
            'casts'
        ];
    }
}

            // 'movie_genres',
            // 'format_movies'