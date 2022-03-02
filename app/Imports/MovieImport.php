<?php

namespace App\Imports;

use App\Models\Movie;
use Maatwebsite\Excel\Concerns\ToModel;

class MovieImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Movie([
            'name' => $row['name'],
            'director' => $row['director'],
            'description' => $row['description'],
            'trailler' => $row['trailler'],
            'movie_length' => $row['movie_length'],
            'rated' => $row['rated'],
            'status' => Movie::MOVIE_DEACTIVE,
        ]);
    }
}
