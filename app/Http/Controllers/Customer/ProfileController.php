<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\MemberCard;
use App\Models\User;
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
        return Inertia::render('Customer/Profile', [
            'user' => Auth::guard('customer')->user(),
        ]);
    }

    public function myVoucher(Request $request)
    {
        $user = Auth::guard('customer')->user();
        $member_card = MemberCard::where('user_id', $user->id)->first();

        $vouchers =  Voucher::when($request->keyword, function ($q) use ($request) {
            return $q->where("vouchers.code", "=", $request->keyword);
        })
            ->where('user_id', $user->id)
            ->orderBy('status')
            ->orderBy('id', "DESC")
            ->paginate($request->query('limit', 12));

        return Inertia::render('Customer/MyVoucher', [
            'vouchers' => $vouchers,
            'member_card' => $member_card,
            'filterBE' => $request->all(),
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
            if ($member_card->used_point >= MemberCard::POINT_VIP) {
                $member_card->update(['role' => MemberCard::ROLE_VIP]);
            }
            DB::commit();
            $message = ['success' => __('Đổi voucher thành công!')];
        } catch (\Exception $e) {
            $message = ['error' => __($e)];
            DB::rollback();
        } finally {
            return back()->with($message);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        $fill = $request->validated();
        $user = $this->userService->getUser();
        try {
            $this->userService->updateUser($request, $user);
            $user->email != $fill['email']
                ? $text = 'Bạn cần xác thực email để  hoàn thành việc thay đổi !'
                : $text = 'Cập nhật thông tin thành công !';
            $message = ['success' => __($text)];
        } catch (\Exception $e) {
            $message = ['error' => __($e)];
        } finally {
            return back()->with($message);
        }
    }

    public function AuthenticateMail(Request $request)
    {
        $fill =  $request->validate([
            'id' => 'required',
            'email' => ['required', 'email'],
        ]);
        try {
            User::where('id', $fill['id'])
                ->update(['email' => $fill['email'], 'email_verified_at' => now()]);
            $message = ['success' => __('Cập nhật email thành công !')];
        } catch (\Exception $e) {
            $message = ['error' => __($e)];
        } finally {
            return redirect()->route('profile')->with($message);
        }
    }
}
