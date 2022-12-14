<?php

namespace App\Http\Controllers\Backs\SuperAdmin;

use App\Exports\MovieExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
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

    public function create()
    {
        return Inertia::render("Backs/SuperAdmin/FormMovie");
    }

    public function edit()
    {
        $movie_genres = $this->movieService->getListMovieGenre();

        return Inertia::render("Backs/SuperAdmin/FormMovie", [
            'movie_genres' => $movie_genres,
        ]);
    }

    // public function edit(SeatTypeRequest $request, $id)
    // {
    //     try {
    //         $fill = $request->validated();
    //         $this->movieService->update($id, $fill);
    //         $message = ['success' => __('update seat type successful')];
    //     } catch (\Exception $e) {
    //         $message = ['error' => __('something went wrong')];
    //     } finally {
    //         return back()->with($message);
    //     }
    // }

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

    public function store(MovieRequest $request)
    {
        try {
            $fill = $request->validated();
            $this->movieService->store($fill);
            $message = ['success' => __('create movie successful')];
        } catch (\Exception $e) {
            $message = ['error' => __('something went wrong')];
        } finally {
            return redirect()->route('superadmin.movie.index')->with($message);
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
}
