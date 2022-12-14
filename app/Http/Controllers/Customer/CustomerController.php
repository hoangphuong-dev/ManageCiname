<?php

namespace App\Http\Controllers\Customer;

use App\Helper\FormatDate;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePassWordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Mail\ForgotPassword;
use App\Models\User;
use App\Repositories\CinemaRepository;
use App\Repositories\ProvinceRepository;
use App\Services\BillService;
use App\Services\MovieGenreService;
use App\Services\MovieService;
use App\Services\SeatTypeService;
use App\Services\ShowTimeService;
use App\Services\TicketService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use PDF;

class CustomerController extends Controller
{
    private const SESSION_KEY = 'order_info';

    public $movieGenreService;
    public $movieService;
    public $provinceRepository;
    public $cinemaRepository;
    public $billService;
    public $userService;
    public $ticketService;
    public $showTimeService;
    public $seatTypeService;

    public function __construct(
        MovieGenreService $movieGenreService,
        MovieService $movieService,
        ProvinceRepository $provinceRepository,
        CinemaRepository $cinemaRepository,
        ShowTimeService $showTimeService,
        TicketService $ticketService,
        BillService $billService,
        UserService $userService,
        SeatTypeService $seatTypeService,
    ) {
        $this->billService = $billService;
        $this->userService = $userService;
        $this->ticketService = $ticketService;
        $this->movieGenreService = $movieGenreService;
        $this->movieService = $movieService;
        $this->provinceRepository = $provinceRepository;
        $this->cinemaRepository = $cinemaRepository;
        $this->showTimeService = $showTimeService;
        $this->seatTypeService = $seatTypeService;
    }

    public function login()
    {
        return Inertia::render("Customer/Login");
    }

    public function forgotPasword()
    {
        return Inertia::render("Customer/ForgotPassword");
    }

    public function confirmForgotPassword(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        return Inertia::render('Customer/ChangePassword', [
            'id' => $request->id,
        ]);
    }

    public function handleConfirmForgotPassword(ChangePassWordRequest $request)
    {
        $fill = $request->validated();
        try {
            $user = User::findOrFail($fill['id']);
            $user->update(['password' => Hash::make($fill['password'])]);
            $message = ['success' => __('Thay ?????i m???t kh???u th??nh c??ng !')];
        } catch (\Exception $e) {
            $message = ['error' => __('Email ch??a ???????c k??ch ho???t !')];
            return back()->with($message);
        }
        return $user->role == User::ROLE_CUSTOMER
            ? redirect()->route('customer.login')->with($message)
            : redirect()->route('back.login.get')->with($message);
    }

    public function handleForgotPassword(ForgotPasswordRequest $request)
    {
        $fill = $request->validated();
        try {
            $user = User::where('email', $fill['email'])->firstOrFail();
            Mail::to($fill['email'])->send(new ForgotPassword($user->id));
            $message = ['success' => __('Vui l??ng x??c th???c email ????? thay ?????i m???t kh???u !')];
        } catch (\Exception $e) {
            $message = ['error' => $e->getMessage()];
        }
        return back()->with($message);
    }

    public function handleLogin(LoginRequest $request)
    {
        try {
            $fill = $request->validated();
            $route = $this->userService->login($fill);
        } catch (\Exception $e) {
            $message = ['error' => $e->getMessage()];
        } finally {
            if (isset($message)) {
                return back()->with($message);
            }
            return redirect($route);
        }
    }

    public function logout()
    {
        $this->userService->logoutCustomer();
        return redirect()->route('customer.login');
    }

    public function index(Request $request)
    {
        $movie_genres = $this->movieGenreService->all();
        $movieHot = $this->movieService->getMovieHot();
        $movies = $this->movieService->list($request);

        return Inertia::render('Customer/Home', [
            'movieHot' => $movieHot,
            'movieGenre' => $movie_genres,
            'movies' => $movies,
            'filtersBE' => $request->all(),
        ]);
    }

    public function detailMovie($id)
    {
        $movie = $this->movieService->show($id);
        // todo : lay id the loai truyen vao day 
        $arr_movie_genre_id = ["1", "2"];
        $movie_relates = $this->movieService->getMovieRelated($arr_movie_genre_id);
        return Inertia::render('Customer/MovieDetail', [
            'movie' => $movie,
            'movie_relates' => $movie_relates,
        ]);
    }

    public function getProvince()
    {
        return $this->provinceRepository->list();
    }

    public function getCinemaByProvince($id)
    {
        $province = $this->cinemaRepository->listCinemaByProvince($id);
        return response()->json($province, 200);
    }

    public function showSeatByShowTime(Request $request)
    {
        // lay ra thong tin cua suat chieu hien tai (phong , so ghe trong, daban, id_rap )
        $showtime = $this->showTimeService->getRoomByShowTime($request->current_showtime);

        // l???y c??c gh??? ???? b??n c???a su???t chi???u hi???n t???i 
        $seat_ordered = $this->ticketService->getSeatOrdered($request->current_showtime);

        $seat_types = $this->seatTypeService->list($request);
        $time = strtotime('+1 minute', strtotime(date_format(now(), "Y-m-d H:i:s")));
        $count_down = date('Y-m-d H:i:s', $time);

        $result = [
            'showtime' => $showtime,
            'seat_ordered' => $seat_ordered,
            'seat_types' => $seat_types,
            'count_down' => $count_down,
        ];

        if ($request->redirect == 'staff') {
            return Inertia::render('Backs/Staff/ViewRoom', $result);
        }

        return Inertia::render('Customer/ViewRoom', $result);
    }


    public function orderTicket(Request $request)
    {
        $data = $request->all();

        $date = Carbon::now()->toDateString();
        if (!isset($data['current_date'])) {
            $data['current_date'] = $date;
        }
        $showtimes =  ($this->showTimeService->listShowTimeByCinema($data)->collection);

        $formatDate = new FormatDate();
        $twoWeeks = $formatDate->getTwoWeek();

        $result = [
            'twoWeeks' => $twoWeeks,
            'filterFE' => $data,
            'showtimes' => $showtimes,
        ];

        if ($request->redirect == 'staff') {
            return Inertia::render('Backs/Staff/ShowTime', $result);
        }

        return Inertia::render('Customer/ViewShowTime', $result);
    }

    public function NoticationSendMail()
    {
        return Inertia::render('Customer/NoticationSendMail');
    }

    public function orderSuccess($id)
    {
        return Inertia::render('Customer/OrderSuccess', [
            'bill_id' => $id
        ]);
    }

    public function downloadPDF($id)
    {
        $tickets = $this->ticketService->getTicketByBill($id);

        $pdf = PDF::loadView('user.view_ticket_pdf', [
            'tickets' => $tickets,
        ]);
        return $pdf->stream('ticket.pdf')->header('Content-Type', 'application/pdf');
    }

    public function myTicket(Request $request)
    {
        $user = Auth::guard('customer')->user();

        $bills = $this->billService->getBillCustomer($user->id);

        return Inertia::render('Customer/MyTicket', [
            'bills' => $bills,
            'filtersBE' => $request->all(),
        ]);
    }

    public function showCinemaFromCustomer()
    {
        $provinces = $this->cinemaRepository->getProvinceAllCinema();

        return Inertia::render('Customer/SystemCinema', [
            'provinces' => $provinces,
        ]);
    }

    public function viewMovieByCinema(Request $request, $cinemaId)
    {
        $request['cinema'] = $cinemaId;
        $movies = $this->movieService->list($request);

        $movie_genres = $this->movieGenreService->all();
        $movieHot = $this->movieService->getMovieHot();

        return Inertia::render('Customer/Home', [
            'movieHot' => $movieHot,
            'movieGenre' => $movie_genres,
            'movies' => $movies,
            'filtersBE' => $request->all(),
        ]);
    }
}
