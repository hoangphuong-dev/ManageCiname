<?php

namespace App\Http\Controllers\Backs\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeatTypeRequest;
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

    public function edit(SeatTypeRequest $request, $id)
    {
        try {
            $fill = $request->validated();
            $this->seatTypeService->update($id, $fill);
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
            $this->seatTypeService->delete($id);
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
            $this->seatTypeService->store($fill);
            $message = ['success' => __('create seat type successful')];
        } catch (\Exception $e) {
            $message = ['error' => __('something went wrong')];
        } finally {
            return back()->with($message);
        }
    }
}
