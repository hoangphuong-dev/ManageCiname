<?php

namespace App\Http\Controllers\Customer;

use App\Events\CustomerOrder;
use App\Exceptions\CustomerException;
use App\Helper\FormatDate;
use App\Helper\JwtHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Mail\AuthenOrder;
use App\Repositories\CinemaRepository;
use App\Repositories\ProvinceRepository;
use App\Services\BillService;
use App\Services\MovieGenreService;
use App\Services\MovieService;
use App\Services\ShowTimeService;
use App\Services\TicketService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use PDF;

class CustomerController extends Controller
{
    private const SESSION_KEY = 'order_info';

    public $movieGenreService;
    public $movieSearvice;
    public $provinceRepository;
    public $cinemaRepository;
    public $billService;
    public $userService;
    public $ticketService;
    public $showTimeService;

    public function __construct(
        MovieGenreService $movieGenreService,
        MovieService $movieService,
        ProvinceRepository $provinceRepository,
        CinemaRepository $cinemaRepository,
        ShowTimeService $showTimeService,
        TicketService $ticketService,
        BillService $billService,
        UserService $userService,
    ) {
        $this->billService = $billService;
        $this->userService = $userService;
        $this->ticketService = $ticketService;
        $this->movieGenreService = $movieGenreService;
        $this->movieSearvice = $movieService;
        $this->provinceRepository = $provinceRepository;
        $this->cinemaRepository = $cinemaRepository;
        $this->showTimeService = $showTimeService;
    }

    public function login()
    {
        return Inertia::render("Customer/Login");
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

        $movie_genres = $this->movieGenreService->list($request);
        // cac phim dang co suat chieu va duoc dat nhieu nhat
        $movie_hots = $this->movieSearvice->getMovieHot();

        // dd($movie_hots);


        return Inertia::render('Customer/Home', [
            'movie_genres' => $movie_genres,
            'movie_hots' => $movie_hots,
        ]);
    }

    public function detailMovie($id)
    {
        $movie = $this->movieSearvice->show($id);
        // todo : lay id the loai truyen vao day 
        $arr_movie_genre_id = ["1", "2"];
        $movie_relates = $this->movieSearvice->getMovieRelated($arr_movie_genre_id);
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
        return $this->cinemaRepository->listCinemaByProvince($id);
    }

    public function showSeatByShowTime(Request $request)
    {
        // lay ra thong tin cua suat chieu hien tai (phong , so ghe trong, daban, id_rap )
        $showtime = $this->showTimeService->getRoomByShowTime($request->current_showtime);

        return Inertia::render('Customer/ViewRoom', [
            'showtime' => $showtime,
        ]);
    }


    public function orderTicket(Request $request)
    {
        $data = $request->all();
        $date = Carbon::now()->toDateString();
        if (!isset($data['current_date'])) {
            $data['current_date'] = $date;
        }
        // dd($data);
        $showtimes =  ($this->showTimeService->listShowTimeByCinema($data)->collection);


        $formatDate = new FormatDate();
        $twoWeeks = $formatDate->getTwoWeek();
        return Inertia::render('Customer/ViewShowTime', [
            'twoWeeks' => $twoWeeks,
            'filterFE' => $data,
            'showtimes' => $showtimes,
        ]);
    }

    public function getInfoCustomer(Request $request)
    {
        $data = $request->all();

        session()->put(self::SESSION_KEY, $data);

        return Inertia::render('Customer/ConfirmOrder');
    }

    public function order(Request $request)
    {
        $fill = $request->all();
        $fill['total_money'] = "500000";
        $data = array_merge($fill, session()->get(self::SESSION_KEY, []));

        // dd($data);

        // generate token from JWT
        $token = JwtHelper::make($data);

        Mail::to($data['email'])->send(new AuthenOrder($token));
        // dua ra trang thong bao vua gui mail

        // return redirect()->back();

        dd($token);
    }

    public function authenOrder($token)
    {
        if (JwtHelper::isExpired($token) === true) {
            return "Token da het han , Vui long dat lai ve khac !";
        }
        $data = JwtHelper::parse($token);

        $flag = true;
        // try {
        //     DB::beginTransaction();
        $user = $this->userService->checkOrderCustomer($data);

        $bill = $this->billService->createBill($user->id, $data);

        $this->ticketService->createTicket($data, $bill->id);
        //     DB::commit();
        // } catch (\Exception $e) {
        //     $flag = false;
        //     DB::rollback();
        //     return back()->with($e);
        // }
        if ($flag) {
            event(new CustomerOrder($bill, $user));

            return redirect()->route('order-success', $bill->id);

            // dd("success");
        }
        session()->forget(self::SESSION_KEY);
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

    public function myTicket()
    {
        $user = Auth::guard('customer')->user();

        $bills = $this->billService->getBillCustomer($user->id);
        // dd($bills);
        return Inertia::render('Customer/MyTicket', [
            'bills' => $bills,
        ]);
    }

    // lay phim đang chiếu và sắp chiếu 
    public function getMovieNowShowing(Request $request)
    {
        $movies = $this->movieSearvice->getMovieNowShowing($request);

        dd($movies);
    }
}
