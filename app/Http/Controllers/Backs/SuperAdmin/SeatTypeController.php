<?php

namespace App\Http\Controllers\Backs\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SeatType;
use App\Services\SeatTypeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SeatTypeController extends Controller
{
    protected $seatTypeService;

    public function __construct(SeatTypeService $seatTypeService)
    {
        $this->seatTypeService = $seatTypeService;
    }

    public function index(Request $request)
    {
        $seatTypes = $this->seatTypeService->list($request);

        return Inertia::render('Backs/SuperAdmin/SeatType', [
            'seatTypes' => $seatTypes,
            'filtersBE' => $request->all()
        ]);
    }

    public function edit(Request $request, $id)
    {
        // return $this->seatTypeService->edit($request, $id);
        $message = ['error' => "Tinh nang nay van dang duoc phat trien them"];
        return back()->with($message);
    }

    public function delete($id)
    {
        try {
            $this->seatTypeService->delete($id);
            $message = ['success' => 'Xóa thành công'];
        } catch (\Exception $e) {
            $message = ['error' => __('something went wrong')];
        } finally {
            return back()->with($message);
        }
    }


    public function uploadImage(Request $request)
    {
        $url = $this->seatTypeService->uploadImage($request);

        dd($url);

        return response()->json([
            'status' => 200,
            'url' => $url,
        ]);
    }
}