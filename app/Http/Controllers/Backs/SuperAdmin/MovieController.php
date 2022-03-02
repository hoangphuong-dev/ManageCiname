<?php

namespace App\Http\Controllers\Backs\SuperAdmin;

use App\Exports\MovieExport;
use App\Http\Controllers\Controller;
use App\Imports\MovieImport;
use App\Services\MovieGenreService;
use App\Services\MovieService;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class MovieController extends Controller
{

    protected $movieService;
    protected $movieGenreService;

    public function __construct(MovieService $movieService, MovieGenreService $movieGenreService)
    {
        $this->movieService = $movieService;
        $this->movieGenreService = $movieGenreService;
    }

    public function index()
    {
        return Inertia::render("Backs/SuperAdmin/Movie");
    }

    public function importCsv(Request $request)
    {
        try {
            Excel::import(new MovieImport, request()->file('file'));
            $message = ['success' => __('Import thành công !')];
        } catch (\Exception $e) {
            $message = ['error' => __('Có lỗi trong quá trình thực thi !')];
        } finally {
            return back()->with($message);
        }
    }

    public function exportCsv()
    {
        return Excel::download(new MovieExport, 'movies.xlsx');
    }

    public function create()
    {
        $adminInfo = $this->movieService->getProvinceShowMovie();
        $movie_genres = $this->movieGenreService->all();
        return Inertia::render("Backs/SuperAdmin/FormMovie", [
            'adminInfo' => $adminInfo,
            'movie_genres' => $movie_genres,
        ]);
    }

    public function delete($id)
    {
        try {
            $this->movieService->delete($id);
            $message = ['success' => __('Xóa thành công !')];
        } catch (\Exception $e) {
            $message = ['error' => __('Có lỗi trong quá trình thực thi !')];
        } finally {
            return back()->with($message);
        }
    }

    public function edit($id)
    {
        $movie = $this->movieService->edit($id);
        return Inertia::render(
            'Backs/SuperAdmin/EditMovie',
            [
                'movie' => $movie
            ]
        );
    }
}
