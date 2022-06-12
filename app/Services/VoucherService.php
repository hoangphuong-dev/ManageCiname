<?php

namespace App\Services;

use App\Repositories\VoucherRepository;

/**
 * Class VoucherService
 * @package App\Services
 */
class VoucherService
{
    private $voucherRepository;

    public function __construct(VoucherRepository $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }

    public function checkVoucher($fill)
    {
        if (isset($fill['voucher'])) {
            try {
                $voucher = $this->voucherRepository->getVoucherByUserd($fill);
                $fill['voucher_type'] = $voucher->type;

                return $fill;
            } catch (\Exception $e) {
                $message = ['error' => __('Voucher không hợp lệ hoặc đã được sử dụng !')];
                return redirect()->back()->with($message);
            }
        }
        return $fill;
    }

    public function applyVoucher($data)
    {
        $data['flag_voucher'] = false;
        if (isset($data['user_id']) && isset($data['voucher_type'])) {
            $voucher = $this->voucherRepository->checkApplyVoucher($data);

            if (!is_null($voucher)) {
                $data['flag_voucher'] = true;
                $data['voucher_id'] = $voucher->id;
                $data['total_money'] *= ($data['voucher_type'] / 100);
                $this->voucherRepository->appLyVoucher($voucher->id);
                return $data;
            }
        }
        return $data;
    }

    public function updateBillId($billId, $id)
    {
        return $this->voucherRepository->updateBillId($billId, $id);
    }
}