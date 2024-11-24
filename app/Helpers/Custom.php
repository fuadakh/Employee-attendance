<?php

namespace App\Helpers;

use DB;
use Illuminate\Support\Facades\Auth;
use Datetime;
use Request;
use Illuminate\Support\Facades\URL;
use Str;
use Carbon\Carbon;

class Custom {
    public static function changeDBToDate($date = '')
    {
        if(empty($date)){
            return $date;
        } else {
            $data_month     = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des');
            $explode_date    = explode('-', $date);
            $explode_to_date = explode(' ', $explode_date[2]);
            $month             = '';
            if ($date != '0000-00-00') {
                for ($x = 1; $x <= 12; $x++) {
                    if (intval($explode_date[1]) == $x) {
                        $month = $x;
                        break;
                    }  
                }
                return $explode_to_date[0] . ' ' . $data_month[$month] . ' ' . $explode_date[0];
            } else
                return SystemHelper::changeDBToDate(date('Y-m-d'));
        }
    }
    public static function changeDBToDatetime($date = '')
    {
        $date_time = Custom::changeDBToDate(date('Y-m-d', strtotime($date))) . ' ' . date('H:i:s', strtotime($date));
        return $date_time;
    }
}