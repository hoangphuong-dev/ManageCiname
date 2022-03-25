<?php

namespace App\Http\Controllers\Customer;

use App\Events\CustomerOrder;
use App\Exceptions\CustomerException;
use App\Helper\FormatDate;
use App\Helper\JwtHelper;
use App\Http\Controllers\Controller;
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

    public function index(Request $request)
    {
        $movie_genres = $this->movieGenreService->list($request);
        return Inertia::render('Customer/Home', [
            'movie_genres' => $movie_genres
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
        // lay ra thong tin cua suat chieu hien tai (phong , so ghe trong, daban )
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
            throw new CustomerException(__('token expired'));
        }
        $data = JwtHelper::parse($token);

        // dd($data);

        $flag = true;
        // try {
        //     DB::beginTransaction();
        $user = $this->userService->checkOrderCustomer($data);

        $bill = $this->billService->createBill($user->id, $data['total_money']);

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
}
