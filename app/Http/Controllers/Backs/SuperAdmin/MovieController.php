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

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index(Request $request)
    {
        $movies = $this->movieService->list($request);
        $movieGenre  = $this->movieService->getListMovieGenre();

        return Inertia::render('Backs/SuperAdmin/Movie', [
            'movies' => $movies,
            'movieGenre' => $movieGenre,
            'filtersBE' => $request->all()
        ]);
    }

    public function edit(SeatTypeRequest $request, $id)
    {
        try {
            $fill = $request->validated();
            $this->movieService->update($id, $fill);
            $message = ['success' => __('update seat type successful')];
        } catch (\Exception $e) {
            $message = ['error' => __('something went wrong')];
        } finally {
            return back()->with($message);
        }
    }

    public function delete($id)
    {
        try {
            $this->movieService->delete($id);
            $message = ['success' => 'Xóa thành công'];
        } catch (\Exception $e) {
            $message = ['error' => __('something went wrong')];
        } finally {
            return back()->with($message);
        }
    }

    public function store(SeatTypeRequest $request)
    {
        try {
            $fill = $request->validated();
            $this->movieService->store($fill);
            $message = ['success' => __('create seat type successful')];
        } catch (\Exception $e) {
            $message = ['error' => __('something went wrong')];
        } finally {
            return back()->with($message);
        }
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

    // public function create()
    // {
    //     $movie_genres = $this->movieGenreService->all();

    //     return Inertia::render("Backs/SuperAdmin/FormMovie", [
    //         'movie_genres' => $movie_genres,
    //     ]);
    // }

    // public function delete($id)
    // {
    //     try {
    //         $this->movieService->delete($id);
    //         $message = ['success' => __('Xóa thành công !')];
    //     } catch (\Exception $e) {
    //         $message = ['error' => __('Có lỗi trong quá trình thực thi !')];
    //     } finally {
    //         return back()->with($message);
    //     }
    // }

    // public function edit($id)
    // {
    //     // $movie = $this->movieService->edit($id);
    //     // return Inertia::render(
    //     //     'Backs/SuperAdmin/EditMovie',
    //     //     [
    //     //         'movie' => $movie
    //     //     ]
    //     // );
    // }
}
