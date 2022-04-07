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
use App\Services\SeatTypeService;
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
        $this->movieSearvice = $movieService;
        $this->provinceRepository = $provinceRepository;
        $this->cinemaRepository = $cinemaRepository;
        $this->showTimeService = $showTimeService;
        $this->seatTypeService = $seatTypeService;
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
        // lấy các phim có suất chiếu và được đặt nhiều nhất
        $movie_hots = $this->movieSearvice->getMovieHot();
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

        // lấy các ghế đã bán của suất chiếu hiện tại 
        $seat_ordered = $this->ticketService->getSeatOrdered($request->current_showtime);

        $seat_types = $this->seatTypeService->list($request);
        $time = strtotime('+1 minute', strtotime(date_format(now(), "Y-m-d H:i:s")));
        $count_down = date('Y-m-d H:i:s', $time);

        return Inertia::render('Customer/ViewRoom', [
            'showtime' => $showtime,
            'seat_ordered' => $seat_ordered,
            'seat_types' => $seat_types,
            'count_down' => $count_down,
        ]);
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
        return Inertia::render('Customer/ViewShowTime', [
            'twoWeeks' => $twoWeeks,
            'filterFE' => $data,
            'showtimes' => $showtimes,
        ]);
    }

    public function getInfoCustomer(Request $request)
    {
        $data = $request->all();
        $showtime = $this->showTimeService->getRoomByShowTime($data['showtime_id']);
        session()->put(self::SESSION_KEY, $data);

        return Inertia::render('Customer/ConfirmOrder', [
            'showtime' => $showtime,
            'data' => $data,
        ]);
    }

    public function order(Request $request)
    {
        $fill = $request->all();
        $data = array_merge($fill, session()->get(self::SESSION_KEY, []));

        $token = JwtHelper::make($data);

        Mail::to($data['email'])->send(new AuthenOrder($token));

        return redirect()->route('notication-send-mail');
    }

    public function NoticationSendMail()
    {
        return Inertia::render('Customer/NoticationSendMail');
    }

    public function authenOrder($token)
    {
        if (JwtHelper::isExpired($token) === true) {
            return "Token đã hết hạn . Vui lòng đặt lại vé khác !";
        }
        $flag = true;
        try {
            $data = JwtHelper::parse($token);
            DB::beginTransaction();
            $user = $this->userService->checkOrderCustomer($data);
            $bill = $this->billService->createBill($user->id, $data);
            $this->ticketService->createTicket($data, $bill->id, $user->id);
            DB::commit();
        } catch (\Exception $e) {
            $message = ['error' => __('Ghế này đã được đặt , Vui lòng chọn ghế khác')];
            $flag = false;
            DB::rollback();
            return redirect()->route('home')->with($message);
        }
        if ($flag) {
            event(new CustomerOrder($bill, $user));

            return redirect()->route('order-success', $bill->id);
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

    // lấy phim đang chiếu
    public function getMovieNowShowing(Request $request)
    {
        $movie_genres = $this->movieGenreService->list($request);
        $movies = $this->movieSearvice->getMovieNowShowing($request);
        return Inertia::render('Customer/MovieNowShowing', [
            'movies' => $movies,
            'movie_genres' => $movie_genres,
        ]);
    }
    // sắp chiếu
    public function getMovieCommingSoon(Request $request)
    {
        $movies = $this->movieSearvice->getMovieCommingSoon($request);
        $movie_genres = $this->movieGenreService->list($request);
        return Inertia::render('Customer/MovieNowShowing', [
            'movies' => $movies,
            'movie_genres' => $movie_genres,
            'title' => 'Phim sắp chiếu'
        ]);
    }
}
