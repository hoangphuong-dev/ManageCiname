<?php

namespace App\Helper;

use Carbon\CarbonPeriod;

class FormatDate
{
    public static function getFourteenDay()
    {
        $start_date = date('Y-m-d');
        $code_date = strtotime('+2 week', strtotime($start_date));
        $end_date = date('Y-m-d', $code_date);
        return $end_date;
    }

    public static function getTwoWeek()
    {
        $arr = array();

        $start_date = date('Y-m-d');
        $end_date = self::getFourteenDay();
        $period = CarbonPeriod::create($start_date, $end_date);

        foreach ($period as $item) {
            $date = $item->format('Y-m-d'); // lay ngay thang nam 
            $show = $item->format('d-m');
            $day = self::formatWeekday($item->format('l')); // lay thu trong tuan 
            array_push($arr, array('week' =>  $day, 'day' => $date, 'show' => $show));
        }
        return $arr;
    }

    public static function formatWeekday($weekday)
    {
        $weekday = strtolower($weekday);
        switch ($weekday) {
            case 'monday':
                $weekday = 'Thứ hai';
                break;
            case 'tuesday':
                $weekday = 'Thứ ba';
                break;
            case 'wednesday':
                $weekday = 'Thứ tư';
                break;
            case 'thursday':
                $weekday = 'Thứ năm';
                break;
            case 'friday':
                $weekday = 'Thứ sáu';
                break;
            case 'saturday':
                $weekday = 'Thứ bảy';
                break;
            default:
                $weekday = 'Chủ nhật';
                break;
        }
        return $weekday;
    }

    public static function getPeriodDate($startDate, $endDate)
    {
        $arr = array();
        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $day) {
            array_push($arr, $day->format('d-m-Y'));
        }
        return $arr;
    }
}
