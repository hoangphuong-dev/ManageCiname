<?php

namespace App\Repositories;

use App\Models\Voucher;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class VoucherRepository.
 */
class VoucherRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Voucher::class;
    }

    public function getVoucherByUserd($fill)
    {
        return $this->model->query()
            ->where('code', $fill['voucher'])
            ->where('status', Voucher::NOTUSED)
            ->where('expiration_date', '>=', now())
            ->where('user_id', $fill['user_id'])
            ->firstOrFail();
    }

    public function checkApplyVoucher($data)
    {
        return $this->model
            ->where('user_id', $data['user_id'])
            ->where('code', $data['voucher'])
            ->where('expiration_date', '>=', now())
            ->first();
    }

    public function appLyVoucher()
    {
        return $this->model->update(['status' => Voucher::USED]);
    }

    public function updateBillId($billId)
    {
        return $this->model->update([
            'bill_id' => $billId,
        ]);
    }
}