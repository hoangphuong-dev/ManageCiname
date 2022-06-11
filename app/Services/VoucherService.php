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
        return;
    }

    public function applyVoucher($data)
    {
        $data['flag_voucher'] = false;
        if (isset($data['user_id']) && isset($data['voucher_type'])) {
            $voucher = $this->voucherRepository->checkApplyVoucher($data);
            if (!is_null($voucher)) {
                $data['flag_voucher'] = true;
                $data['total_money'] *= ($data['voucher_type'] / 100);
                $this->voucherRepository->appLyVoucher();
                return $data;
            }
        }
        return $data;
    }

    public function updateBillId($billId)
    {
        return $this->voucherRepository->updateBillId($billId);
    }
}