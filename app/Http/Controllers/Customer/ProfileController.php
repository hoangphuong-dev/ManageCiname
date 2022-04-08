<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MemberCard;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::guard('customer')->user();
        dd($user);
    }



    public function myVoucher()
    {
        $user = Auth::guard('customer')->user();
        $member_card = MemberCard::where('user_id', $user->id)->first();

        $vouchers =  Voucher::paginate(10);

        return Inertia::render('Customer/MyVoucher', [
            'vouchers' => $vouchers,
            'member_card' => $member_card,
        ]);
    }

    public function exchangePoint(Request $request)
    {
        $data = $request->all();

        $user = Auth::guard('customer')->user();
        $code_date = strtotime('+1 week', strtotime(Carbon::now()));
        $expiration_date = date('Y-m-d H:i:s', $code_date);
        $member_card = MemberCard::where('user_id', $user->id)->first();
        try {
            DB::beginTransaction();
            Voucher::create([
                'user_id' => $user->id,
                'code' => Str::random(10),
                'title' =>  $data['title'],
                'type' =>  $data['chooseVoucher'],
                'expiration_date' =>  $expiration_date,
            ]);

            $member_card->update([
                'accumulating_point' => $member_card->accumulating_point - $data['need_point'],
                'used_point' => $member_card->used_point + $data['need_point'],
            ]);
            DB::commit();
            $message = ['success' => __('Đổi voucher thành công!')];
        } catch (\Exception $e) {
            $message = ['error' => __('Có lỗi trong quá trình thực thi !')];
            DB::rollback();
        } finally {
            return back()->with($message);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
