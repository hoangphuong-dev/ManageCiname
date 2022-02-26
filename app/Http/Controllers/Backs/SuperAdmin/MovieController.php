<?php

namespace App\Http\Controllers\Backs\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\MovieGenre;
use App\Services\MovieGenreService;
use App\Services\MovieService;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
}
