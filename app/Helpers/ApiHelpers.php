<?php

use Carbon\Carbon;

/**
 * Return a new response from the application.
 * 
 * @see App\Helpers\Apihelpers.php
 * @param  boolean  $success
 * @param  string   $message
 * @param  array    $data
 * @param  int      $status
 * @param  string   $token
 * @param  array    $errors
 * @return \Illuminate\Http\Response
 */
function resp($success, $message, $data, $status, $token = "",  $errors = []){
    return response([
        'success' => $success,
        'message' => $message,
        'data' => $data,
        'token' => $token,
        'erros' => $errors
    ], $status);
}

/**
 * Return a int distance user from office.
 * 
 * @see App\Helpers\Apihelpers.php
 * @param  float  $latitude1
 * @param  float  $longitude1
 * @param  float  $latitude2
 * @param  float  $longitude2
 * @return int
 */
function getDistance($latitude1, $longitude1, $latitude2 = null, $longitude2 = null)
{
    if (is_null($latitude2)) {
        $latitude2 = env('LATITUDE_OFFSET');
    }

    if (is_null($longitude2)) {
        $longitude2 = env('LONGITUDE_OFFSET');
    }

    $degrees = rad2deg(acos((sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($longitude1 - $longitude2)))));

    $distance = $degrees * 111.13384;

    return (round($distance, 2));
}

/**
 * Return a date today and ourfrom int.
 * 
 * @see App\Helpers\Apihelpers.php
 * @param  int  $hour
 * @param  int  $minute
 * @param  int  $second
 * @return Carbon\Carbon
 */
function get_today_time($hour, $minute = 0, $second = 0){
    $today = Carbon::today();
    $today->hour = $hour;
    $today->minute = $minute;
    $today->second = $second;
    return $today;
}


/**
 * Return a date limit from the application.
 * 
 * @see App\Helpers\Apihelpers.php
 * @param  int  $start_time
 * @param  int   $end_time
 * @return Carbon\Carbon array
 */
function format_batas($start_time, $end_time){
    return [
        'start' => get_today_time($start_time),
        'end' => get_today_time($end_time),
    ];
}